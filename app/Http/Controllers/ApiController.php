<?php

namespace App\Http\Controllers;

use App\Business\ApiBusiness;
use App\Business\FileUtils;
use App\Business\MyException;
use App\Business\MyResponse;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateApiRequest;
use App\Http\Requests\UpdateApiRequest;
use App\Jobs\SendWhatsAppMsgApi;
use App\Models\Api;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Status;
use App\Models\User;
use App\Repositories\ApiRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Response;

class ApiController extends AppBaseController
{
    const RECEIVED = 1;
    const SENDED = 2;
    const STOPPED = 3;
    const PROBLEM = 4;
    // const RECEIVED = 8;
    // const SENDED = 9;
    // const STOPPED = 10;
    // const PROBLEM = 11;

    /** @var  ApiRepository */
    private $apiRepository;

    public function __construct(ApiRepository $apiRepo)
    {
        $this->apiRepository = $apiRepo;
    }

    // public function create_company_api_jobs(Request $Request)
    // {
    //     try {
    //         // dd("ok  ");
            
    //         $APIBusiness = new ApiBusiness();

    //         $APIBusiness->createCompaniesJobs();

    //     } catch (\Throwable $th) {
    //         return MyResponse::makeExceptionJson($th);
    //     }

    //     return MyResponse::makeResponseJson("ok");
    // }

    /**
     * Display a listing of the Api.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $User = Auth::check() ? Auth::user() : session('logged_user');

        $page = (int) ($request->page ?? '0');
        $searchInput = (string) ($request->searchInput ?? '');
        $apis = $this->apiRepository->apiMessagesByCompany($User->company_id, $page, $searchInput);

        $apis->toJson();

        // return view('apis.index')
        //     ->with('apis', $apis);
    }

    /**
     * Show the form for creating a new Api.
     *
     * @return Response
     */
    public function create()
    {
        return view('apis.create');
    }

    /**
     * Store a newly created Api in storage.
     *
     * @param CreateApiRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $User = User::where('api_token', $request->api_token)->first();
        if (!$User) {
            $erro = MyResponse::makeResponseJson('invalid api_token!', null, -1, false);
            return $erro;
        }

        $input = $request->all();

        Log::debug('ApiController Store ', [$input]);

        // Check if the Contact already exist for this company
        $Contact = Contact::where([
            'company_id' => $User->company_id,
            'whatsapp_id' => $request->phone,
        ])->first();

        if (!$Contact) { // if not exist insert the contact
            $Contact = new Contact();
            $Contact->company_id = $User->company_id;
            $Contact->first_name = $request->first_name ?? $request->phone;
            $Contact->whatsapp_id = $request->phone;
            $Contact->email = $request->email ?? null;
            $Contact->origin = ContactsOriginsController::API;
            $Contact->save();
        }

        $file = $input['file'] ?? null;
        Log::debug('ApiController Store Files', [$file]);

        
        // $file_name = $request->file()->getFileName();

        if (isset($input['file'])) {
            $filePath = "companies/$Contact->company_id/contacts/$Contact->id/chat_files";
            $json_data = FileUtils::SavePostFile($request->file, $filePath, $file->getBasename());
            if ($json_data) { // Save file to disk (public/app/..)
                $input['file_name'] = "$filePath/$json_data->SavedFileName";
                $input['file_type'] = '2';
                Log::debug('ApiController Store Saved File', [$json_data]);
            }
        }

        $input['contact_id'] = $Contact->id;
        
        $input['status_id'] = ApiController::RECEIVED;

        // Create Api message model
        $this->apiRepository->model->setTable($User->company_id);
        $api = $this->apiRepository->create($input);
        $input['id'] = $api->id;
        
        // Create Job
        $Company = Company::with('rpi')->find($User->company_id);
        $ExternalRPIController = new ExternalRPIController($Company->rpi);
        unset($input['file']);

        // $allow = 1;
        // $every = 60;
        // Redis::throttle('SendWhatsAppMsgApi')->allow($allow)->every($every)->then(function () use ($ExternalRPIController, $Contact, $input) {
        //     // Job logic...
            // SendWhatsAppMsgApi::dispatch($ExternalRPIController, $Contact, $input, 'api_messages');
    
        //     Flash::success('Api message saved successfully.');
        // }, function () use ($allow, $every, &$api) {
        //     // Could not obtain lock...
        //     // return $this->release($allow);
        //     $erro = MyResponse::makeResponseJson("Apenas permitimos $allow messages every $every secounds", null, 0, false);
        //     Log::debug('ApiController store Redis Limit: ', [$erro, $api]);
        //     $api = $erro;
        //     return $erro;
        // });

        return $api;
    }

    /**
     * Display the specified Api.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $api = $this->apiRepository->findWithoutFail($id);

        if (empty($api)) {
            Flash::error('Api not found');

            return redirect(route('apis.index'));
        }

        return view('apis.show')->with('api', $api);
    }

    /**
     * Show the form for editing the specified Api.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $api = $this->apiRepository->findWithoutFail($id);

        if (empty($api)) {
            Flash::error('Api not found');

            return redirect(route('apis.index'));
        }

        return view('apis.edit')->with('api', $api);
    }

    /**
     * Update the specified Api in storage.
     *
     * @param  int              $id
     * @param UpdateApiRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateApiRequest $request)
    {
        $api = $this->apiRepository->findWithoutFail($id);

        if (empty($api)) {
            Flash::error('Api not found');

            return redirect(route('apis.index'));
        }

        $api = $this->apiRepository->update($request->all(), $id);

        Flash::success('Api updated successfully.');

        return redirect(route('apis.index'));
    }

    /**
     * Remove the specified Api from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $api = $this->apiRepository->findWithoutFail($id);

        if (empty($api)) {
            Flash::error('Api not found');

            return redirect(route('apis.index'));
        }

        $this->apiRepository->delete($id);

        Flash::success('Api deleted successfully.');

        return redirect(route('apis.index'));
    }

    public function generateApiToken(){

        try{
        $User = Auth::check() ? Auth::user() : session('logged_user');

            if($User->api_token == null){
        
                $apiKey = Str::random(32);
                $User->api_token = $apiKey;
                $User->save();
            }
                //dd($User);

        }catch (\Throwable $tr) {
            throw $tr;
        }
        


    }
}

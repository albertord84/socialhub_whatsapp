<?php

namespace App\Http\Controllers;

use App\Business\MyResponse;
use App\Http\Requests\CreateApiRequest;
use App\Http\Requests\UpdateApiRequest;
use App\Repositories\ApiRepository;
use App\Http\Controllers\AppBaseController;
use App\Jobs\SendWhatsAppMsgApi;
use App\Models\Company;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ApiController extends AppBaseController
{
    /** @var  ApiRepository */
    private $apiRepository;

    public function __construct(ApiRepository $apiRepo)
    {
        $this->apiRepository = $apiRepo;
    }

    /**
     * Display a listing of the Api.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->apiRepository->pushCriteria(new RequestCriteria($request));
        $apis = $this->apiRepository->all();

        return view('apis.index')
            ->with('apis', $apis);
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
        $input = $request->all();

        $file = $request->file();

        Log::debug('ApiController Store ', [$input, $file]);

        $User = User::where('api_token', $request->api_token)->first();
        if (!$User) { 
            $erro = MyResponse::makeResponseJson('invalid api_token!', null, -1, false);
            return $erro;
        }

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

        $input['contact_id'] = $Contact->id;
        //

        $input['type_id'] = MessagesTypeController::Documents;
        $input['status_id'] = MessagesStatusController::ROUTED;

        // Create Api message model
        $this->apiRepository->model->setTable($User->company_id);
        $api = $this->apiRepository->create($input);
        $input['id'] = $api->id;

        // Create Job
        $Company = Company::with('rpi')->find($User->company_id);
        $ExternalRPIController = new ExternalRPIController($Company->rpi);
        SendWhatsAppMsgApi::dispatch($ExternalRPIController, $Contact, $input, 'api_messages');

        Flash::success('Api message saved successfully.');

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
}

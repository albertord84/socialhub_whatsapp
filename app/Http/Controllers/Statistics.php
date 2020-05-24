<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use App\Models\AttendantsContact;

use App\Http\Controllers\ExtendedContactsStatusController;
use App\Models\ExtendedChat;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use stdClass;

class Statistics extends Controller
{

    public function index() {
        // 5) Quantidade de contatos atribuidos para cada atendente (ok)
        // 1) Quantidade de contatos que vieram da sacola por dia
        // 2) Quantidade de contatos adicionados por dia
        // 4) Mensagens enviadas e recebidas por dia
        // 6) mensagem nao lida por atentende
    }
    
    public function managerGeneralStatistics(Request $request) {
        $company_id = $request['company_id'];

        // whatsapp Number
        $whatsappNumber = Contact::find($company_id)->whatsapp;

        // Total de contatos
        $totalContacts = Contact::where('company_id',$company_id)->get()->count();

        $Attendants = User::where('company_id',$company_id)->where('role_id', ExtendedContactsStatusController::ATTENDANT)->get();

        // Total mensagens enviados e recebidos da empresa segundo os atendentes (incluir bling e correios depois)
        $totalSendMessages = 0;
        $totalReceivedMessages = 0;
        $ExtendedChat = new ExtendedChat();
        foreach ($Attendants as $i => $Attendant) {
            $ExtendedChat->table = $Attendant->id;
            $tmp = $ExtendedChat->where('source','0')->get()->count();
            //total de mensagens enviados
            $totalSendMessages += $tmp;
            //total de mensagens enviados deste atendente
            $Attendants[$i]->sendedMessageAmmount = $tmp;
            
            //total de mensagens recebidos
            $totalReceivedMessages += $ExtendedChat->where('source','1')->get()->count();            
        }
                
        // Contatos  por atendente        
        $AttendantsContact = new AttendantsContact();
        foreach ($Attendants as $i => $Attendant) {
            $Attendants[$i]->contactsAmmount = $AttendantsContact->where('attendant_id', $Attendant->id)->get()->count();
        }
        
        return array(
            'whatsappNumber' => $whatsappNumber,
            'totalContacts' => $totalContacts,
            'totalSendMessages' => $totalSendMessages,
            'totalReceivedMessages' => $totalReceivedMessages,
            'attendants' => $Attendants,
        );
    }

    public function frequencyOfContactByAttendant(Request $request) {
        $company_id = $request['company_id'];
        $contactFrequency = $request['contactFrequency'] ?? 'Y-m';
        // frequencia de contatos por atendente
        $Attendants = User::where('company_id',$company_id)->where('role_id', ExtendedContactsStatusController::ATTENDANT)->get();
        $AttendantsContact = new AttendantsContact();

        foreach ($Attendants as $i => $Attendant) {
            //frequencia
            $Attendants[$i]->contactsAmmountFrequency = $AttendantsContact
                ->select('created_at')
                ->where('attendant_id', $Attendant->id)
                ->orderBy('created_at')
                ->get()                
                ->groupBy(function ($val) use ($contactFrequency) {
                    return Carbon::parse($val->created_at)->format($contactFrequency);
                });
        }

        $names = [];
        foreach ($Attendants as $i => $Attendant) {
            array_push($names, explode('@', $Attendant->email)[0]);
        }

        $arr = [];
        foreach ($Attendants as $i => $Attendant) {
            foreach($Attendant->contactsAmmountFrequency as $key => $val){
                foreach($names as $name){
                    $arr[$name][$key] = 0;
                }
                
            }
        }
        foreach ($Attendants as $i => $Attendant) {
            foreach($Attendant->contactsAmmountFrequency as $key => $val){
                    $arr[explode('@', $Attendant->email)[0]][$key] = count($val);
            }
        } 
        return $arr;

    }

    public function frequencyOfMessageByAttendant(Request $request) {
        $company_id = $request['company_id'];
        $messageFrequency = $request['messageFrequency'] ?? 'Y-m';
        // frequencia de mensagens enviadas por atendente
        $Attendants = User::where('company_id',$company_id)->where('role_id', ExtendedContactsStatusController::ATTENDANT)->get();
        $ExtendedChat = new ExtendedChat();
        foreach ($Attendants as $i => $Attendant) {
            //frequencia
            $ExtendedChat->table = $Attendant->id;
            $Attendants[$i]->contactsMessageFrequency = $ExtendedChat
                ->select('created_at')
                ->where('source','0')
                ->orderBy('created_at')
                ->get()                
                ->groupBy(function ($val) use ($messageFrequency) {
                    return Carbon::parse($val->created_at)->format($messageFrequency);
                });
        }
        $names = [];
        foreach ($Attendants as $i => $Attendant) {
            array_push($names, explode('@', $Attendant->email)[0]);
        }

        $arr = [];
        foreach ($Attendants as $i => $Attendant) {
            foreach($Attendant->contactsMessageFrequency as $key => $val){
                foreach($names as $name){
                    $arr[$name][$key] = 0;
                }
                
            }
        }
        foreach ($Attendants as $i => $Attendant) {
            foreach($Attendant->contactsMessageFrequency as $key => $val){
                    $arr[explode('@', $Attendant->email)[0]][$key] = count($val);
            }
        } 
        return $arr;
    }

    public function managerBlingStatistics($company_id) {

    }

    public function managerTrackingStatistics($company_id) {

    }
}

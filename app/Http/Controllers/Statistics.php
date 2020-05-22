<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use App\Models\AttendantsContact;

use App\Http\Controllers\ExtendedContactsStatusController;
use App\Models\ExtendedChat;
use Illuminate\Http\Request;

class Statistics extends Controller
{

    public function index() {
        // 5) Quantidade de contatos atribuidos para cada atendente (ok)
        // 1) Quantidade de contatos que vieram da sacola por dia
        // 2) Quantidade de contatos adicionados por dia
        // 4) Mensagens enviadas e recebidas por dia
        // 6) mensagem nao lida por atentende
    }
    
    public function managerGeneralStatistics($company_id) {
        // Total de contatos
        $whatsappNumber = Contact::find($company_id)->whatsapp_id;

        // Total de contatos
        $totalContacts = Contact::where('company_id',$company_id)->get()->count();
        
        // Total de atendentes
        $Attendants = User::where('company_id',$company_id)->where('role_id', ExtendedContactsStatusController::ATTENDANT)->get();
        $totalAttendants = $Attendants->count();

        // Total mensagens enviados e recebidos, e Quantidade de mensagens enviadas por cada atendente
        $totalSendMessages = 0;
        $totalReceivedMessages = 0;
        $ExtendedChat = new ExtendedChat();
        foreach ($Attendants as $i => $Attendant) {
            $ExtendedChat->table = $Attendant->id;
            $tmp = $ExtendedChat->where('source','0')->get()->count();
            $totalSendMessages += $tmp;
            $Attendants[$i]->sendedMessageAmmount = $tmp;
            $totalReceivedMessages += $ExtendedChat->where('source','1')->get()->count();            
        }

        // Quantidade de contatos atribuidos para cada atendente
        $AttendantsContact = new AttendantsContact();
        foreach ($Attendants as $i => $Attendant) {
            $Attendants[$i]->contactsAmmount = $AttendantsContact->where('attendant_id', $Attendant->id)->get()->count();            
        }
        
        $statistics = array(
            'whatsappNumber' => $whatsappNumber,
            'totalContacts' => $totalContacts,
            'totalAttendants' => $totalAttendants,
            'totalSendMessages' => $totalSendMessages,
            'totalReceivedMessages' => $totalReceivedMessages,
            'attendants' => $Attendants,
        );

        return $statistics;
    }

    public function managerBlingStatistics($company_id) {

    }

    public function managerTrackingStatistics($company_id) {

    }
}

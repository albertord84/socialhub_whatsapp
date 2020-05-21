<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;

use App\Http\Controllers\ExtendedContactsStatusController;
use Illuminate\Http\Request;

class Statistics extends Controller
{

    public function index() {
        // 5) Quantidade de contatos atribuidos para cada atendente
        // 1) Quantidade de contatos que vieram da sacola por dia
        // 2) Quantidade de contatos adicionados por dia
        // 3) Tempo Médio de respostas (das 9h às 18h. Geral e por atendentes.
        // 4) Mensagens enviadas por dia e mensagens recebidas
    }
    
    public function managerGeneralStatistics($company_id) {
        // Total de contatos
        $whatsappNumber = Contact::find($company_id)->whatsapp_id;

        // Total de contatos
        $totalContacts = Contact::where('company_id',$company_id)->get()->count();
        
        // Total de atendentes
        $totalAttendants = User::where('company_id',$company_id)->where('role_id', ExtendedContactsStatusController::ATTENDANT)->get()->count();

        // Total mensagens enviados
        $totalSendMessages = 0;

        // Total mensagens recebidos
        
        // Status do whatsapp

        // Frequencia de mensagens enviados e recebidos

        $statistics = array(
            'whatsappNumber' => $whatsappNumber,
            'totalContacts' => $totalContacts,
            'totalAttendants' => $totalAttendants,
            'totalSendMessages' => 1,
            'totalReceivedMessages' => 1,
            'whatsappStatus' => 1,
            'frequencySendedMessages' => [],
            'frequencyReceivedMessages' => [],
        );

        return $statistics;
    }

    public function managerBlingStatistics($company_id) {

    }

    public function managerTrackingStatistics($company_id) {

    }
}

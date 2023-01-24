<?php
require 'vendor/autoload.php';
use Telegram\Bot\Api;

$api_key = "5941177584:AAHbMHYuN_tbeOptcsRmOJ3eEs3mKpWMM1E";
$client = new Api($api_key);
/* per l'attivazione del long polling memorizziamo
l'id dell'ultimo update elaborato */
echo $api_key;
$last_update_id=0;
while(true){
    // leggiamo gli ultimi update ottenuti
	$response = $client->getUpdates(['offset'=>$last_update_id, 'timeout'=>5]);
	if (count($response)<=0) continue;
	/* per ogni update scaricato restituiamo il messaggio
	sulla stessa chat su cui è stato ricevuto */
	foreach ($response as $r){
        $last_update_id=$r->getUpdateId()+1;
		
		$message=$r->getMessage();
		$chatId=$message->getChat()->getId();
		$text=$message->getText();

		if($text == "/start") {
			$response = $client->sendMessage([
				'chat_id' => $chatId,
				'text' => 'Benvenuto, che partita ti interessa?'
		  	]);
		}
		else if($text == "/napoli_juve") {
			
			$giornoPartita = "📆Giorno: 13-01-2023";
			$squadre = "Partita: Napoli - Giuventus";
			$risultato = "Risultato: 5⃣-5⃣";
			$marcatori = "🔵🔵 14' VICTOR OSIMHEN\n🔵🔵 39' KVARACOSO\n⚫⚪ 42' ANGÈL DI MARIA\n🟨  44' DANILO\n🔵🔵 55' AMIR RRAHMANI\n🔵🔵 65' VICTOR OSIMHEN\n🔵🔵 72' ELJIF ELMAS\n⚫⚪ 90' DUSANSESSUALE\n⚫⚪ 90+1' DUSANSESSUALE\n⚫⚪ 90+2' PLUSVALENZA\n⚫⚪ 90+3' PLUSVALENZA\n";

			send($chatId, $giornoPartita, $squadre, $risultato, $marcatori);
		}
		else {
			$res = json_decode(file_get_contents('https://livescore-api.com/api-client/scores/events.json?id=129180&key=KApavnX28UfvETOH&secret=yiACMJpHfQlSG5YrFoBaLycTtsp8mdPU'), true);
			$data = $res['data'];
			$match = $data['match'];

			$giornoPartita = "📆Giorno: " . $match['date'];
			$squadre = "Partita: " . $match['home_name'] . " - " . $match['home_name'];
			$risultato = "Risultato: " . $match['score'];

			$marcatori = "";
			if($risultato != "0-0") {
				$marcatori = "Marcatori:\n";
				foreach ($data['event'] as $event) {
					if ($event['event'] == "GOAL") {
						$marcatori .= $event['time'] ."'". "  ⚽ - " . $event['player'] . "\n";
					}
					else if ($event['event'] == "OWN_GOAL") {
						$marcatori .= $event['time'] ."'". "  ↩️ - " . $event['player'] . "\n";
					}
					else if ($event['event'] == "GOAL_PENALTY") {
						$marcatori .= $event['time'] ."'". " ®🥅 - " . $event['player'] . "\n";
					}
					else if ($event['event'] == "YELLOW_CARD") {
						$marcatori .= $event['time'] ."'". "  🟨 - " . $event['player'] . "\n";
					}
					else if ($event['event'] == "RED_CARD" || $event['event'] == "YELLOW_RED_CARD") {
						$marcatori .= $event['time'] ."'". "  🟥 - " . $event['player'] . "\n";
					}
					else if ($event['event'] == "MISSED_PENALTY") {
						$marcatori .= $event['time'] ."'". " ®❌ - " . $event['player'] . "\n";
					}
				}
			}

			send($chatId, $giornoPartita, $squadre, $risultato, $marcatori);

		}
		//cd ../../xampp/htdocs/telegram
	}
}

function send($chatId, $giornoPartita, $squadre, $risultato, $marcatori) {
	global $client;
	
	$response = $client->sendMessage([
		'chat_id' => $chatId,
		'text' => $giornoPartita . "\n" . $squadre . "\n" . $risultato . "\n" . $marcatori
	  ]);
}
?>
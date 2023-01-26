<?php
//TODO ricerca partite per nome squadra







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

		$competitionId = null;

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

			sendMatch($chatId, $giornoPartita, $squadre, $risultato, $marcatori);
		}
		// else if ($text == "/italia") {

		// 	$competitionId = 47;
		// 	//$url = 'https://livescore-api.com/api-client/countries/list.json?date=today&key=EC1cUn35m2S80WdY&secret=MJZysWmZywk6cHxQky3fW7ki9cra8E8V';
		// 	$url = 'https://livescore-api.com/api-client/competitions/list.json?key=EC1cUn35m2S80WdY&secret=MJZysWmZywk6cHxQky3fW7ki9cra8E8V&country_id='. $competitionId;
		// 	$res = json_decode(file_get_contents($url), true);
		// 	$competitions = $res['data']['competition'];

		// 	$leauges = "";
		// 	foreach ($competitions as $c) {
		// 		$leauges .= $c . "\n";
		// 	}

		// 	sendLeagues($chatId, $leauges);
		// }
		else {
			$countriesId = [47];//, 19, 43, 21, 1];
			$countryIndex = 0;

			$countriesUrl = "https://livescore-api.com/api-client/countries/list.json?key=EC1cUn35m2S80WdY&secret=MJZysWmZywk6cHxQky3fW7ki9cra8E8V";
			$teamsUrl = "https://livescore-api.com/api-client/teams/list.json?key=EC1cUn35m2S80WdY&secret=MJZysWmZywk6cHxQky3fW7ki9cra8E8V";
			$teamId = null;
			
			$page = 1;
			//			$res = json_decode(file_get_contents('https://livescore-api.com/api-client/teams/list.json?key=EC1cUn35m2S80WdY&secret=MJZysWmZywk6cHxQky3fW7ki9cra8E8V&country_id=47'), true);
			
			while ($teamId == null) {
				
				//Tutti i paesi sono già stati controllati
				if($countryIndex == count($countriesId)) {
					sendMatch($chatId, "Nessuna squadra trovata.", "", "", "");
					break;
				}
				
				//ricerca lista di squadre per country e per pagina
				$res = json_decode(file_get_contents($teamsUrl . "&country_id=" . $countriesId[$countryIndex] . "&page=" . $page), true);
				$data = $res['data'];
				$teams = $data['teams'];

				foreach ($teams as $team) {
					//controllo se il nome è uguale, se lo trovo salvo l'id e chiamo findMatch
					if (strtoupper($team['name']) == strtoupper($text)) {
						$teamId = $team['id'];
						findMatch($teamId);
						break;
					}
				}
				
				//se ho finito di controllare le squadre in questa pagina, passo alla prossima pagina
				if ($data['next_page']) {
					$page++;
				}
				//se non ci sono altre pagine, passo al prossimo paese
				else {
					$countryIndex++;
				}
			}
		}
	}
}

function findMatch($teamId) {
	$matchUrl = "http://livescore-api.com/api-client/scores/history.json?key=EC1cUn35m2S80WdY&secret=MJZysWmZywk6cHxQky3fW7ki9cra8E8V";

	$page = 1;

	$res = json_decode(file_get_contents($matchUrl . "&team=" . $teamId . "&page=" . $page), true);
	$data = $res['data'];
	$matches = $data['matche'];	

	$page = $data['total_pages'];

	$completeMessage = "";
	for($i = 0; $i < 5; $i++) {
		$completeMessage .= writeMatch($matches[count($matches) - 1 - $i]);
	}
	

			

	// 		sendMatch($chatId, $giornoPartita, $squadre, $risultato, $marcatori);

}

function writeMatch($match) {
	$giornoPartita = "📆Giorno: " . $match['date'];
	$squadre = "Partita: " . $match['home_name'] . " - " . $match['home_name'];
	$risultato = "Risultato: " . $match['score'];

	$marcatori = "";
	if($risultato != "0-0") {
		$marcatori .= getEvents($match['id']);
	}

	return $giornoPartita . "\n" . $squadre . "\n" . $risultato . "\n" . $marcatori . "\t---   ---   ---   ---";
}

function getEvents($matchId) {
	$matchUrl = "https://livescore-api.com/api-client/scores/events.json?key=EC1cUn35m2S80WdY&secret=MJZysWmZywk6cHxQky3fW7ki9cra8E8V";
	$res = json_decode(file_get_contents($matchUrl . "&id=" . $matchId), true);
			$data = $res['data'];
			//$match = $data['match'];

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
	return $marcatori;
}

function sendMatch($chatId, $giornoPartita, $squadre, $risultato, $marcatori) {
	global $client;
	
	$response = $client->sendMessage([
		'chat_id' => $chatId,
		'text' => $giornoPartita . "\n" . $squadre . "\n" . $risultato . "\n" . $marcatori
	  ]);
}

function sendLeagues($chatId, $leauges) {
	global $client;
	
	$response = $client->sendMessage([
		'chat_id' => $chatId,
		'text' => $leauges
	  ]);
}
?>
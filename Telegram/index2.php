<?php
$res = json_encode(file_get_contents('https://livescore-api.com/api-client/scores/events.json?id=129180&key=KApavnX28UfvETOH&secret=yiACMJpHfQlSG5YrFoBaLycTtsp8mdPU'));
echo gettype($res);

$data = $res["data"];

echo "DATAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA";
print_r($data);

$match = json_encode($data['match']);

echo "MATCHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH";
print_r($match);
?>
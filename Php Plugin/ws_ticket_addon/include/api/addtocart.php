<?php

$parameters = $request->get_json_params();
$id=$parameters['data']['id'];
echo $id;


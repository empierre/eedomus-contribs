<?php

$GLOBALS['api_key'] = getArg('API');
$GLOBALS['api_ip'] = getArg('ip');
$GLOBALS['api_url'] = 'http://'.$api_ip.'/';


function sdk_activate_irrigation($zone, $minutes)
{
  $response = httpQuery($GLOBALS['api_url'].'cm?pw='.$GLOBALS['api_key'].'&sid='.($zone-1).'&en=1&t='.$minutes, 'GET', $post);
  return $response;
}

function sdk_stop_irrigation($zone) 
{
  $response = httpQuery($GLOBALS['api_url'].'cm?pw='.$GLOBALS['api_key'].'&sid='.($zone-1).'&en=0', 'GET', $post);
  return $response;
}

function sdk_auto_irrigation($zone) 
{
    //do nothing
}


function sdk_get_valves_state_and_config() 
{
  $response = httpQuery($GLOBALS['api_url'].'js?pw='.$GLOBALS['api_key'], 'GET', $post);
  return $response;
}

$action = getArg('action');
$zone_number = getArg('zone_number');

switch($action)
{
  case 'start':
    $duration = getArg('duration');
    $result = sdk_activate_irrigation($zone_number, $duration*60);
  break;
  
  case 'stop':
    $result = sdk_stop_irrigation($zone_number);
  break;
	
	case 'auto':
    $result = sdk_auto_irrigation($zone_number);
  break;
  
  case 'status':
    $response = sdk_get_valves_state_and_config();
    $arr = sdk_json_decode($response);
    $result = '{"status": "'.$arr['sn'][$zone_number-1].'"}';
    
  break;
  
  default:
    $result = '{"status":false,"msg":"Unknown action ['.$action.']"}';
  break;
}

echo $result;

?>

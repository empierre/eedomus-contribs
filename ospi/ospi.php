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

function sdk_get_program_state() 
{
  $response = httpQuery($GLOBALS['api_url'].'jp?pw='.$GLOBALS['api_key'], 'GET', $post);
  return $response;
}

function sdk_launch_program($pid) 
{
  $response = httpQuery($GLOBALS['api_url'].'mp?pw='.$GLOBALS['api_key'].'&pid='.($pid).'&uwt=0', 'GET', $post);
  return $response;
}

function sdk_enable_program($pid) 
{
  $response = httpQuery($GLOBALS['api_url'].'cp?pw='.$GLOBALS['api_key'].'&pid='.($pid).'&en=1', 'GET', $post);
  return $response;
}

function sdk_disable_program($pid) 
{
  $response = httpQuery($GLOBALS['api_url'].'cp?pw='.$GLOBALS['api_key'].'&pid='.($pid).'&en=0', 'GET', $post);
  return $response;
}

function sdk_get_pid($program_name) 
{
  $response = httpQuery($GLOBALS['api_url'].'jp?pw='.$GLOBALS['api_key'], 'GET', $post);
  $arr = sdk_json_decode($response);
  foreach($arr["pd"] as $item) {
    if($item[5] == utf8_encode($program_name)) return $k+1;
    $k++;
  }
  return 0;
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

switch($action)
{
  case 'start':
    $duration = getArg('duration');
    $zone_number = getArg('zone_number');
    $result = sdk_activate_irrigation($zone_number, $duration*60);
  break;
  
  case 'stop':
    $zone_number = getArg('zone_number');
    $result = sdk_stop_irrigation($zone_number);
  break;
	
  case 'auto':
    $zone_number = getArg('zone_number');
    $result = sdk_auto_irrigation($zone_number);
  break;
  
  case 'programenablelaunch':
    $program_name = getArg('program_name');
    $pid = sdk_get_pid($program_name);
    if($pid==0) {
        $result = '{"status":false,"msg":"Unknown program ['.$program_name.']"}';
    } else {
        $result = sdk_enable_program($pid-1); 
        $result = sdk_launch_program($pid-1); 
    }
  break;		
		
  case 'programenable':
    $program_name = getArg('program_name');
    $pid = sdk_get_pid($program_name);
    if($pid==0) {
        $result = '{"status":false,"msg":"Unknown program ['.$program_name.']"}';
    } else {
        $result = sdk_enable_program($pid-1); 
    }
  break;
  
  case 'programdisable':
    $program_name = getArg('program_name');
    $pid = sdk_get_pid($program_name);
    if($pid==0) {
        $result = '{"status":false,"msg":"Unknown program ['.$program_name.']"}';
    } else {
        $result = sdk_disable_program($pid-1);
    }
  break;
  
  case 'programstatus':
    $program_name = getArg('program_name');
    $pid = sdk_get_pid($program_name);
    if($pid==0) {
        $result = '{"status":false,"msg":"Unknown program ['.$program_name.']"}';
    } else {
        $response = sdk_get_program_state();
        $arr = sdk_json_decode($response);
        $result = '{"status": "'.substr(decbin($arr['pd'][$pid-1][0]), -1).'"}';
    }
  break;
  
  case 'status':
    $zone_number = getArg('zone_number');
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

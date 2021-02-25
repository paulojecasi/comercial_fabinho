<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//--- PJCS 

function datebr($date){
	return date("d/m/Y", strtotime($date));
}

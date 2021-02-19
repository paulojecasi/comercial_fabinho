<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function reais($valor){
	return 	number_format($valor,2,",",".");
}

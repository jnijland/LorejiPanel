<?php

class Cli_Api extends Controller
{
	public static function ip()
	{
		printf("Current IP: ".System::Remote_ip()."\n");;
		printf("\n");
	}
}
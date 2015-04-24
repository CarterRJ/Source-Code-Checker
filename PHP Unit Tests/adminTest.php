<?php

class adminTest extends PHPUnit_Framework_TestCase
{
	 /**
     * @runInSeparateProcess
     */
	
    public function testAdminOnly()
    {	
		ob_start();
		$_SESSION ['Admin'] = 0;
		include '../login/admin.php';
		$output = ob_get_contents();
		ob_end_clean();
		$this->assertContains('<meta http-equiv=\'refresh\'', $output);
		$this->assertNotContains('Call Stack', $output);
    }
	 /**
     * @runInSeparateProcess
     */
	
	public function testNoSession()
    {	
		ob_start();
		include '../login/admin.php';
		$output = ob_get_contents();
		ob_end_clean();
		$this->assertContains('<meta http-equiv=\'refresh\'', $output);
		$this->assertNotContains('Call Stack', $output);		
    }
	 
}
?>
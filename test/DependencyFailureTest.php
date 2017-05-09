<?php
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: hanseh
 * Date: 09/05/2017
 * Time: 8:41 PM
 */
class DependencyFailureTest extends TestCase
{
	public function testOne()
	{
		$this->assertTrue(true);
	}
	
	/**
	 * @depends testOne
	 */
	public function testTwo()
	{
		$this->assertTrue(true);
	}
}
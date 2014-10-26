<?php namespace Projammer\Models;

use TestCase;
class RequirementTest extends TestCase {

	protected $requirement;

	public function setUp() {
		parent::setUp();
		$this->requirement = new Requirement([
			"id"=>1,
			"project_id"=>1,
			"code"=>"M3.1",
			"name"=>"Test Requirement",
			"description"=>"Test Requirement Description",
			"status"=>"proposed",
			"complexity"=>"hours",
			"priority"=>"M",
			"created_by"=>1,
			"last_updated_by"=>1
		]);
	}

	public function testInvalidWithoutProjectID() {
		$this->requirement->project_id = NULL;
		$this->assertFalse($this->requirement->isValid(), "Requirement should be invalid without project_id");
	}

	public function testValidWithoutCode() {
		$this->requirement->code = "";
		$this->assertTrue($this->requirement->isValid(), "Requirement should be valid without a code");
	}

	public function testInvalidWithOverlongCode() {
		$this->requirement->code = "verylongcodehere";
		$this->assertFalse($this->requirement->isValid(), "Requirement should be invalid without a code longer than 8 chars (".$this->requirement->code.")");
	}

	public function testIsInvalidWithoutName() {
		$this->requirement->name = "";
		$this->assertFalse($this->requirement->isValid(), "Requirement should be invalid when no name is set");
	}

	public function testIsValidWithoutDescription() {
		$this->requirement->description = "";
		$this->assertTrue($this->requirement->isValid(), "Requirement should be valid even without description");
	}

	public function testIsValidWithoutStatus() {
		$this->requirement->status = "";
		$this->assertTrue($this->requirement->isValid(), "Requirement should be valid even without status");
	}

	public function testIsInvalidWithBadStatus() {
		$this->requirement->status = "Nonsense";
		$this->assertFalse($this->requirement->isValid(), "Requirement should not be valid with status ".$this->requirement->status);
	}	

	public function testIsValidWithoutComplexity() {
		$this->requirement->complexity = "";
		$this->assertTrue($this->requirement->isValid(), "Requirement should be valid even without complexity");
	}

	public function testIsInvalidWithBadComplexity() {
		$this->requirement->complexity = "Ridiculous";
		$this->assertFalse($this->requirement->isValid(), "Requirement should be invalid with complexity ".$this->requirement->complexity);
	}

	public function testIsInvalidWithoutCreator() {
		$this->requirement->created_by = NULL;
		$this->assertFalse($this->requirement->isValid(), "Requirement should be invalid without creator");
	}

	public function testIsValidWithoutUpdater() {
		$this->requirement->updatedBy = NULL;
		$this->assertTrue($this->requirement->isValid(), "Requirement should be valid even without updater");
	}

	public function testIsValidAsExpected() {
		$this->assertTrue($this->requirement->isValid(), $this->requirement->getErrors());
	}

}
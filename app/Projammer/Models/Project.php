<?php 
/**
 * Definition of class \Projammer\Project
 * @filesource 
 * @author  Alex Callard <alex@wearenotmachines.com>
 */
namespace Projammer\Models;
use Projammer\Models\Option;
use Projammer\Models\Client;
use Projammer\Models\Deliverable;
use Projammer\Traits\HasCreatorTrait;
use Projammer\Traits\HasUpdaterTrait;
use SoftDeletingTrait;

/**
 * Defines an identified and contained unit of work for a *Client*, composed of a set of *Requirements*, developed in one or more *Iterations* that yield a set of *Deliverables*, scheduled against *Milestones*
 * @package  Projammer
 */
class Project extends ProjammerModel {
	use HasCreatorTrait, HasUpdaterTrait, SoftDeletingTrait;
	/**
	 * @ignore
	 */
	protected $table = "projects";
	/**
	 * The properties that can be instantiated on construct.
	 * 
	 * ["name","description","start_date", "finish_date", "status", "created_by", "last_updated_by"]
	 * @var array
	 */
	protected $fillable = ["name","description","start_date", "finish_date", "status", "client_id", "created_by", "last_updated_by"];
	/**
	 * The status values permitted for projects.
	 * 
	 * ["presales","planning","development","UAT","beta","live","snagging","archived","cancelled"]
	 * @var array
	 */
	protected static $statuses = ["presales","planning","development","UAT","beta","live","snagging","archived","cancelled"];
	/**
	 * The validation rules that will be passed to Validator::make.
	 * 
	 * [<br />
	 *	"title" => "required",<br />
	 *	"status" => "in:presales,planning,development,uat,beta,live,snagging,archived,cancelled",<br />
	 *	"created_by" => "required",<br />
	 *	"client" => "required"<br />
	 * ]  
	 * @var array
	 */
	protected $validation = [
		"name" => "required",
		"status" => "in:presales,planning,development,uat,beta,live,snagging,archived,cancelled",
		"created_by" => "required",
		"client_id" => "required"
	];

	protected static $componentViewPath = "components.projects";

	/**
	 * Returns the Client for this project.
	 * @return \Projammer\Client the client
	 */
	public function client() {
		return $this->hasOne("Projammer\Models\Client");
	}

	/**
	 * Get the possible statuses that are defined for the project 
	 * 
	 * Marries up with the enum definition in the DB
	 * @package  \Projammer\Models
	 * @return array An array of project status definitions
	 */
	public static function getProjectStatuses() {
		return self::$statuses;
	}

	/**
	 * Gets the Option codes available for the Project 
	 * 
	 * Options are codings that define the different configurations that a project could be delivered in - for example  a website might have an Option A, with fully integrated checkout, or option B with Paypal BuyNow buttons - these would be reflected against deliverables and costings
	 * @package \Projammer\Models
	 * @return \Eloquent\Collection An array of \Projammer\Option objects
	 */
	public function options() {
		return $this->hasMany("Projammer\Models\Option");
	}

	/**
	 * Deliverables attached to the project
	 *
	 * Returns an \Eloquent\Collection of \Projammer\Deliverable objects that have been attached to this project
	 * @package \Projammer\Models
	 * @return \Eloquent\Collection a collection of \Projammer\Deliverable objects
	 */
	public function deliverables() {
		return $this->hasMany("Projammer\Models\Deliverable");
	}

	/**
	 * Get the Phases that are avbailable for this project
	 * @return \Eloquent\Collection a collection of \Projammer\Phase objects
	 */
	public function phases() {
		return $this->hasMany("Projammer\Models\Phase");
	}

	/**
	 * Get the artefact objects linked to this project
	 *
	 * Artefacts can be attached to different objects - this function just returns the artefacts linked to this project at this level.
	 * @return \Eloquent\Collection the collection of \Projammer\Artefact objects attached at project level
	 */
	public function artefacts() {
		return $this->hasMany("Projammer\Models\Artefact");
	}

	public function requirements() {
		return $this->hasMany("Projammer\Models\Requirement");
	}

}
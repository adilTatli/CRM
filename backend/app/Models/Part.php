<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Part",
 *     required={"part_number_id", "task_id", "appliance_id", "distributor_id", "user_id", "status_id", "qnt"},
 *     @OA\Property(property="id", type="integer", description="Unique identifier of the part"),
 *     @OA\Property(property="part_number_id", type="integer", description="Identifier of the part number"),
 *     @OA\Property(property="task_id", type="integer", description="Identifier of the associated task"),
 *     @OA\Property(property="appliance_id", type="integer", description="Identifier of the associated appliance"),
 *     @OA\Property(property="distributor_id", type="integer", description="Identifier of the distributor"),
 *     @OA\Property(property="user_id", type="integer", description="Identifier of the user who added the part"),
 *     @OA\Property(property="status_id", type="integer", description="Identifier of the part status"),
 *     @OA\Property(property="qnt", type="integer", description="Quantity of the parts"),
 *     @OA\Property(property="dealer_price", type="number", format="float", description="Dealer price of the part"),
 *     @OA\Property(property="retail_price", type="number", format="float", description="Retail price of the part"),
 *     @OA\Property(property="distributor_name", type="string", description="Name of the distributor"),
 *     @OA\Property(property="part_description", type="string", description="Description of the part"),
 *     @OA\Property(property="distributor_invoice", type="string", description="Distributor invoice number"),
 *     @OA\Property(property="eta", type="string", format="date-time", description="Estimated time of arrival for the part"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the part was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the part was last updated")
 * )
 */
class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_number_id',
        'task_id',
        'appliance_id',
        'distributor_id',
        'user_id',
        'status_id',
        'qnt',
        'dealer_price',
        'retail_price',
        'distributor_name',
        'part_description',
        'distributor_invoice',
        'eta',
    ];

    /**
     * @OA\Property(
     *     property="partNumber",
     *     description="The part number associated with this part",
     *     ref="#/components/schemas/PartNumber"
     * )
     */
    public function partNumber()
    {
        return $this->belongsTo(PartNumber::class);
    }

    /**
     * @OA\Property(
     *     property="task",
     *     description="The task associated with this part",
     *     ref="#/components/schemas/Task"
     * )
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * @OA\Property(
     *     property="appliance",
     *     description="The appliance associated with this part",
     *     ref="#/components/schemas/Appliance"
     * )
     */
    public function appliance()
    {
        return $this->belongsTo(Appliance::class);
    }

    /**
     * @OA\Property(
     *     property="distributor",
     *     description="The distributor associated with this part",
     *     ref="#/components/schemas/Distributor"
     * )
     */
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    /**
     * @OA\Property(
     *     property="user",
     *     description="The user who added the part",
     *     ref="#/components/schemas/User"
     * )
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @OA\Property(
     *     property="status",
     *     description="The status of the part",
     *     ref="#/components/schemas/PartStatus"
     * )
     */
    public function status()
    {
        return $this->belongsTo(PartStatus::class);
    }
}

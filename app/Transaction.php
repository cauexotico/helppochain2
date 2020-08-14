<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Services\HashService;

use App\Project;
use App\Services\KeypairService;

class Transaction extends Model
{
    protected $fillable = [
        'block_id', 'project_id', 'hash', 'data'
    ];

    /**
     * Create a Transaction.
     *
     * @param Block $block
     * @param json $data
     * @return App\Transaction
     */
    public static function createTransaction(Block $block, $data, $projectId)
    {
        $project = Project::where('id', $projectId)->first();

        $keypairService = new KeypairService();
        $keypair = $keypairService->keypairFromKeys($project->public_key, $project->secret_key);
        $data = $keypairService->cryptMessage($data, hex2bin($project->public_key));
        
        $transaction = [
            'project_id' => $projectId,
            'block_id' => $block->id,
            'hash' => '', //date("Y-m-d H:i:s.u"),
            'data' => bin2hex($data),
        ];

        $hashService = new HashService;
        $transaction = $hashService->hashTransaction($transaction);

        $transaction = Transaction::create($transaction);

        return $transaction;
    }

    public function getDataAttribute($value)
    {
        $keypairService = new KeypairService();
        $keypair = $keypairService->keypairFromKeys($this->project->public_key, $this->project->secret_key);
        $data = $keypairService->decryptMessage(hex2bin($value), $keypair);
        return $data;
    }

    /**
     * Get the Block of this Transaction.
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    /**
     * Get the Block of this Transaction.
     */
    public function block()
    {
        return $this->belongsTo('App\Block');
    }
}

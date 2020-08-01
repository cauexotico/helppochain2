<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Services\HashService;

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
        $transaction = [
            'project_id' => $projectId,
            'block_id' => $block->id,
            'hash' => date("Y-m-d H:i:s.u"),
            'data' => $data,
        ];

        $hashService = new HashService;
        $transaction = $hashService->hashTransaction($transaction);

        $transaction = Transaction::create($transaction);

        return $transaction;
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

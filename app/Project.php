<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Blockchain;
use App\Transaction;

class Project extends Model
{
    protected $fillable = [
        'name', 'type', 'blockchain_id', 'public_key', 'secret_key', 'start_version', 'current_version'
    ];

    /**
     * Try to find an Blockchain that matchs de request.
     * If not found, create a new one.
     *
     * @param string  $type
     * @param int $difficulty
     * @return \App\Blockchain
     */
    public static function findOrCreateBlockchain($type, $difficulty)
    {
        $blockchain = Blockchain::where('type', $type)
                                ->where('difficulty', $difficulty)
                                ->inRandomOrder()
                                ->first();
        
        if (!$blockchain || $type == 'solo') {
            $blockchain = Blockchain::createBlockchain($type, $difficulty);
        }

        return $blockchain;
    }

    /**
     * Stores data inside of the blockchain
     *
     * @return \App\Blockchain
     */
    public function createTransaction($data)
    {
        $latestBlock = $this->blockchain->findLatestOrCreateBlock('not_mined');
        
        $transaction = Transaction::createTransaction($latestBlock, $data, $this->id);

        return $transaction;
    }

    /**
     * Set the project's name.
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    /**
     * Get the transactions of the project.
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    /**
     * Get the blockchain of this Project.
     */
    public function blockchain()
    {
        return $this->belongsTo('App\Blockchain');
    }

}

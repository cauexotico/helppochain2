<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Block;

class Blockchain extends Model
{
    protected $fillable = [
        'version', 'difficulty', 'type'
    ];

    /**
     * Create a new blockchain.
     *
     * @param string  $type
     * @param int $difficulty
     * @return \App\Blockchain
     */
    public static function createBlockchain($type, $difficulty)
    {
        $blockchain = [
            'version' => 'v1',
            'difficulty' => $difficulty,
            'type' => $type,
        ];

        $blockchain = Blockchain::create($blockchain);
        $genesisBlock = Block::createGenesisBlock($blockchain);

        return $blockchain;
    }

    /**
     * Retrive the last block inserted.
     *
     * @return \App\Block
     */
    public function getLatestBlock($status = null)
    {
        $block = Block::where('blockchain_id', $this->id);

        if ($status) {
            $block = $block->where('status', $status);
        }

        $block = $block->latest()->first();

        return $block;
    }

    /**
     * Create a new block.
     *
     * @return \App\Block
     */
    public function createBlock()
    {
        $block = Block::createBlock($this);

        return $block;
    }

    /**
     * Try to find a block matching status or create a new one.
     *
     * @param string $status
     * @return \App\Block
     */
    public function findLatestOrCreateBlock($status = null)
    {
        $latestBlock = $this->getLatestBlock($status);
        
        if(!$latestBlock) {
            $latestBlock = $this->createBlock();
        }
        
        return $latestBlock;
    }


    /**
     * Get the project of the blockchain.
     */
    public function project()
    {
        return $this->hasOne('App\Project');
    }

    /**
     * Get the blocks of the blockchain.
     */
    public function blocks()
    {
        return $this->hasMany('App\Block');
    }
    
}

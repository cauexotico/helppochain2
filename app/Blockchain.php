<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Block;

class Blockchain extends Model
{
    protected $fillable = [
        'name', 'version', 'difficulty', 'type', 'valid'
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
            'name' => Blockchain::createBlockchainName(),
            'version' => getenv('HELPPOCHAIN_CURRENT_VERSION'),
            'difficulty' => $difficulty,
            'height' => 0,
            'type' => $type,
            'valid' => TRUE,
        ];

        $blockchain = Blockchain::create($blockchain);
        $genesisBlock = Block::createGenesisBlock($blockchain);

        return $blockchain;
    }

    /**
     * Create blockchain name
     *
     * @param string $name
     * @return bool
     */
    public static function createBlockchainName()
    {
        $generator = \Nubs\RandomNameGenerator\All::create();
        $name = $generator->getName();

        do {
            $name = $generator->getName();
        } while (!Blockchain::blockchainNameExists($name));

        return $name;
    }
    
    /**
     * Check if blockchain name already exists.
     *
     * @param string $name
     * @return bool
     */
    public static function blockchainNameExists($name)
    {
        $blockchain = Blockchain::where('name', $name);

        if ($blockchain) {
            return true;
        }

        return false;
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
     * Adds +1 to height
     *
     * @return \App\Blockchain
     */
    public function addHeight()
    {
        $this->height = $this->height + 1;
        $this->save();

        return $this->height;
    }

    /**
     * Verify all blockchain
     *
     * @return \App\Blockchain
     */
    public function verifyBlockchainIntegrity ($actualBlock = null)
    {   
        $blockchainBlocks = $this->blocks()->latest()->where('status','mined')->get();

        //if ($actualBlock) {
        //    $blockchainBlocks->push($actualBlock);
        //}

        $error = '';
        foreach($blockchainBlocks as $block) {
            $actualBlockHashDb = $block->hash;
            $actualBlockHashRebuilt = $block->buildHash($block->nonce, true);
            $actualPreviousHash = $block->previous_hash;
            $previousBlockHash = $block->getPreviousBlock();
            
            if (!$previousBlockHash) {
                $previousBlockHash = 'genesis';
            } else {
                $previousBlockHash = $previousBlockHash->hash;
            }
            
            if ($actualBlockHashDb !== $actualBlockHashRebuilt) {
                $error = 'invalid 1';
            }
            
            if ($actualPreviousHash !== $previousBlockHash) {
                $error = 'invalid 2';
            }

            if(!empty($error)) {
                $this->valid = FALSE;
                $this->save();
                
                return $error;
            }
        }

        return 'valid';
    }

    /**
     * Get the valid attribute  
     */
    public function getValidAttribute($value)
    {
        return $value ? 'Válida' : 'Inválida';
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

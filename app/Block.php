<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = [
        'blockchain_id', 'miner', 'nonce', 'previous_hash', 'hash', 'status'
    ];

    /**
     * Create the Genesis Block.
     *
     * @return App\Block
     */
    public static function createGenesisBlock(Blockchain $blockchain)
    {   
        $genesisBlock = [
            'blockchain_id' => $blockchain->id,
            'miner' => null,
            'nonce' => '0',
            'previous_hash' => 'genesis',
            'hash' => '',
            'status' => 'not_mined',
        ];

        $genesisBlock = Block::create($genesisBlock);

        $genesisBlock->mineBlock();
        
        return $genesisBlock;
    }

    /**
     * Create a Block.
     *
     * @return App\Block
     */
    public static function createBlock(Blockchain $blockchain)
    {   
        $block = [
            'blockchain_id' => $blockchain->id,
            'nonce' => '0',
            'previous_hash' => $blockchain->getLatestBlock()->hash,
            'hash' => '',
            'status' => 'not_mined',
        ];

        $block = Block::create($block);

        return $block;
    }

    
    /**
     * Mine a Block.
     * 
     * @param int $nonce
     * @return App\Block
     */
    public function mineBlock()
    {
        if ($this->status == 'mined') {
            return $this;
        }

        $hash = $this->createValidHash();

        $this->nonce = $hash['nonce'];
        $this->hash = $hash['hash'];
        $this->status = 'mined';
        $this->save();
        
        return $this;
    }

    /**
     * Take all params and return a valid hash.
     * 
     * @param int $nonce
     * @return $hash
     */
    public function createValidHash($nonce = 0)
    {
        do {
            $unHashed = $this->blockchain_id . $nonce++ . $this->previous_hash . $this->hash . $this->status;
            $hash = hash('sha256', $unHashed);
        } while (!$this->isValidHashDifficulty($hash));

        $data = [
            'nonce' => $nonce - 1,
            'hash' => $hash,
        ];

        return $data;
    }

    /**
     * Verify if hash is valid.
     * 
     * @param int $nonce
     * @return $hash
     */
    public function isValidHashDifficulty($hash)
    {
        $hashArray = str_split($hash);

        for ($i = 0; $i < count($hashArray) - 1; $i++) {
          if ($hashArray[$i] !== "0") {
            break;
          }
        }

        return $i >= $this->blockchain->difficulty;
    }

    /**
     * Get Shortned Previous Hash.
     * 
     * @param int $length
     * @return string $hash
     */
    public function getShortnedHash($length = null)
    {   
        return $this->shortensHash($this->hash, $length);
    }
    /**
     * Get Shortned Hash.
     * 
     * @param int $length
     * @return string $hash
     */
    public function getShortnedPreviousHash($length = null)
    {   
        return $this->shortensHash($this->previous_hash, $length);
    }

    /**
     * Shortens given Hash.
     * 
     * @param string $hash
     * @param int $length
     * @return string $hash
     */
    public static function shortensHash($hash, $length = null)
    {   
        if (!$hash) {
            return '-';
        }
        
        if ($hash == 'genesis') {
            return $hash;
        }

        if (!$length) {
            $length = 15;
        }

        return substr($hash, 0, $length) . '...';
    }

    /**
     * Get the Blockchain of this Block.
     */
    public function blockchain()
    {
        return $this->belongsTo('App\Blockchain');
    }

    /**
     * Get the Transactions of this Block.
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

}

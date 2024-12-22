<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository
{    
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll(array $filters = [])
    {
        $query =  $this->user->when($filters, function ( Builder $query ) use ( $filters ) {

            if ( isset($filters['name']) )   $query->where('name', 'LIKE', "%{$filters['name']}%");

            if ( isset($filters['email']) )  $query->where('email', 'LIKE', "%{$filters['email']}%");

            if ( isset($filters['active']) ) {

                if($filters['active'])  $query->whereActive(true);
                else  $query->whereActive(false);
                
            }; 
                
        });

        if ( 
            isset( $filters['paginate'] ) && 
            is_numeric( $filters['paginate'] ) 
        )  
            return $query->paginate( $filters['paginate'] );
        else 
            return $query->get();
    }

    public function findById(string $id)
    {
        return $this->user->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->user->create($data);
    }

    public function update(array $data, string $id)
    {
        $user = $this->user->findOrFail($id);

        $user->update($data);
        
        return response()->json([
            'message' => 'success'
        ], 204);
    }

    public function delete(string $id)
    {
        $user = $this->user->findOrFail($id);
        
        $user->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}

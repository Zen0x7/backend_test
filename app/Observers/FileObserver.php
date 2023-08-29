<?php

namespace App\Observers;

use App\Models\File;
use App\Services\UUID;

class FileObserver
{
    /**
     * Handle the File "creating" event.
     */
    public function creating(File $file): void
    {
        $file->uuid = UUID::retrieve();
    }

    /**
     * Handle the File "updated" event.
     */
    public function updated(File $file): void
    {
        //
    }

    /**
     * Handle the File "deleted" event.
     */
    public function deleted(File $file): void
    {
        //
    }

    /**
     * Handle the File "restored" event.
     */
    public function restored(File $file): void
    {
        //
    }

    /**
     * Handle the File "force deleted" event.
     */
    public function forceDeleted(File $file): void
    {
        //
    }
}

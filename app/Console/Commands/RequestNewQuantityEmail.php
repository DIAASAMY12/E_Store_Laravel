<?php

namespace App\Console\Commands;

use App\Mail\VendorQuantityRequestMail;
use App\Models\Item;
use App\Models\Vendor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class RequestNewQuantityEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'email:request-quantity {vendor_id?} {item_name?}';
//    protected $signature = 'email:request-quantity {vendor_id?}';


    protected $signature = 'email:request-quantity {vendor_email?} {item_name?}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to a specific vendor or all vendors to request a new quantity.';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        // Retrieve the command arguments
        $vendorEmail = $this->argument('vendor_email');
        $itemName = $this->argument('item_name');

        $vendorEmail = $vendorEmail === 'null' ? null : $vendorEmail;
        if ($vendorEmail) {
            // If vendor_email is provided, display the vendor information and send the email
            $this->sendVendorRequestEmail($vendorEmail);
        } elseif ($itemName) {
            // If item_name is provided, display all vendors who own this item and send the emails
            $this->sendVendorsItemRequestEmail($itemName);
        } else {
            // If no arguments are provided, display a general message
            $this->info('Please provide a vendor_email or an item_name.');
        }
    }


    private function sendVendorRequestEmail($vendorEmail)
    {
        // Find the vendor by email
        $vendor = Vendor::where('email', $vendorEmail)->first();

        if ($vendor) {
            // Display vendor information
            $this->info('Vendor Information:');
            $this->info('Name: ' . $vendor->first_name . ' ' . $vendor->last_name);
            $this->info('Email: ' . $vendor->email);
            Mail::to($vendor->email)->queue(new VendorQuantityRequestMail($vendor));
        } else {
            $this->error('Vendor not found with the provided email.');
        }
    }

    private function sendVendorsItemRequestEmail($itemName)
    {
        // Find the item by name
        $item = Item::where('name', $itemName)->first();

        if ($item) {
            // Get all vendors who own this item
            $vendors = $item->vendors;

            if ($vendors->isEmpty()) {
                $this->info('No vendors found who own this item.');
            } else {
                $this->info('Vendors who own ' . $itemName . ':');
                foreach ($vendors as $vendor) {
                    $this->info('Name: ' . $vendor->first_name . ' ' . $vendor->last_name);
                    $this->info('Email: ' . $vendor->email);
                    $this->info('------------------------');

                    // Send the request email to each vendor
                    Mail::to($vendor->email)->queue(new VendorQuantityRequestMail($vendor, $item));
                }
            }
        } else {
            $this->error('Item not found with the provided name.');
        }
    }


}

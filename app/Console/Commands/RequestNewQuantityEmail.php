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
    protected $signature = 'email:request-quantity {item_name?}';
//    protected $signature = 'email:request-quantity {vendor_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to a specific vendor or all vendors to request a new quantity.';

    /**
     * Execute the console command.
     */
//    public function handle()
//    {
//        // Get the vendor ID from the command argument
//        $vendorId = $this->argument('vendorId');
//
//
//        if ($vendorId) {
//            // Send email to a specific vendor
//            $vendor = Vendor::find($vendorId);
//
//            if (!$vendor) {
//                $this->error('Vendor not found.');
//                return 1;
//            }
//
//            $this->sendRequestEmailToVendor($vendor);
//            $this->info("Request email sent to vendor {$vendor->name} (ID: {$vendor->id}).");
//        } else {
//            // Send email to all vendors
//            $vendors = Vendor::all();
//
//            foreach ($vendors as $vendor) {
//                $this->sendRequestEmailToVendor($vendor);
//                $this->info("Request email sent to vendor {$vendor->name} (ID: {$vendor->id}).");
//            }
//        }
//
//        return 0;
//    }

    public function handle()
    {
        $itemName = $this->argument('item_name');

        if ($itemName) {
            $item = Item::where('name', $itemName)->first();

            if ($item) {
                $vendorItem = $item->vendorItems()->first();
                $vendorId = $vendorItem->vendor_id;
                $vendor = Vendor::find($vendorId);
                $this->sendRequestEmailToVendor($vendor,$item);
                $this->info("The email sent to the vendor containing the item: $itemName");

            } else {
                $this->error("Item with name: $itemName not found");
            }
        } else {
            $vendors = Vendor::all();

            foreach ($vendors as $vendor) {
                $this->sendRequestEmailToVendor($vendor);
                $this->info("Request email sent to vendor {$vendor->name} (ID: {$vendor->id}).");
            }
        }
    }





    private function sendRequestEmailToVendor(Vendor $vendor, Item $item=null)
    {
        Mail::to($vendor->email)->send(new VendorQuantityRequestMail($item, $vendor));
    }


}

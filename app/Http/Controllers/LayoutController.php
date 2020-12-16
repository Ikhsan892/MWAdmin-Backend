<?php

namespace App\Http\Controllers;

use App\Http\Resources\LayoutResource;
use App\ImageCategory;
use App\Layout;
use Illuminate\Http\Request;

class LayoutController extends Controller
{
    protected $status_code = 404;
    protected $message = [];
    public function index() {
        $responses = [];
        $result = LayoutResource::collection(Layout::latest()->get());
        if(!$result){
          $this->status_code = 500;
          $responses = ['message' => 'Error While getting Layout Resources'];
          return response()->json($responses,$this->status_code);
        }else{
          $this->status_code = 200;
          foreach($result as $r){
            $navbar = json_decode($r->navbar);
            $carousel = json_decode($r->carousel);
            $MCarousel = json_decode($r->MCarousel);
            $footer = json_decode($r->footer);
            $footer_bottom = $r->footer_bottom;
            $responses = [
              'navbar' => $navbar,
              'carousel' => $carousel,
              'MCarousel' => $MCarousel,
              'footer' => $footer,
              'footer_bottom' => $footer_bottom
            ];
          }
          return response()->json($responses,$this->status_code);
        }
    }
    public function insertLayout(Layout $layout){
        $navbar = array(
              'title' => "Makersware Service",
              'navitem' =>  array(
                  array(
                    'label' => "Home",
                    'to' =>  "/home",
                  ),
                  array(
                    'label' => "Track",
                    'to' => "/track",
                  ),
                  array(
                    'label' => "Invoice",
                    'to' => "/invoice",
                  ),
                  array(
                    'label' => "Informasi",
                    'to' => "/information",
                  ),
                ),
            );
        $carousel = array(
          array(
                'label' => "San Francisco – Oakland Bay Bridge, United States",
                'link' =>"https://instagram.com",
                'imgPath' => "/assets/banner1.jpg",
              ),
          array(
                'label' => "Bird",
                'link' => "http://localhost:3000/details/create-slug",
                'imgPath' => "/assets/banner2.jpg",
          ),
          array(
                'label' =>"Bali, Indonesia",
                'link' => "https://instagram.com",
                'imgPath' => "/assets/banner3.jpg",
          ),
          array(
                'label' => "NeONBRAND Digital Marketing, Las Vegas, United States",
                'link' =>"https://instagram.com",
                'imgPath' =>"/assets/banner4.jpg",
          ),
          array(
                'label' => "Goč, Serbia",
                'link' => "https://instagram.com",
                'imgPath' => "/assets/banner5.jpg",
          ),
        );
        // $carousel = ImageCategory::find(1)->images;
        $MCarousel = array(
                array(
                  'label' => "San Francisco – Oakland Bay Bridge, United States",
                  'link' => "https://instagram.com/makerswareofficial",
                  'imgPath' => "/assets/mbanner1.jpg",
                ),
                array(
                  'label' => "Bird",
                  'link' => "https://instagram.com/makerswareofficial",
                  'imgPath' => "/assets/mbanner2.jpg",
                ),
                array(
                  'label' => "Bali, Indonesia",
                  'link' => "https://instagram.com/makerswareofficial",
                  'imgPath' => "/assets/mbanner3.jpg",
                ),
                array(
                  'label' => "NeONBRAND Digital Marketing, Las Vegas, United States",
                  'link' => "https://instagram.com/makerswareofficial",
                  'imgPath' => "/assets/mbanner4.jpg",
                ),
        );
        $footer = array(
              'support_brand' => array(
                'caption' => "Support brand",
                'img' => "/assets/sponsor.png",
              ),
              'about' => array(
                'capt' =>  "Makersware Service Workshop",
                'wa' => array("0889-7697-2688", "0838-7501-2460"),
                'alamat' => array(
                  'jalan' => "Jl. Pengasinan Tengah Raya No. 99 Rawalumbu",
                  'kota_kab' =>"Kota Bekasi",
                  'provinsi' =>"Jawa Barat",
                  'kode_pos' =>"17115",
                ),
                'cta' => array(
                  'title' => "Booking Service",
                  'act' => "https://makerswaredemo.web.app/details/create-slug",
                ),
              ),
              'jam_pelayanan' => array(
                'title_jam_pelayanan' => "Jam Pelayanan",
                'social_media' => array(
                  'instagram'=>"https://instagram.com/makerswareofficial",
                  'facebook'=>"https://facebook.com",
                  'email'=> "admin@makersware.web.id",
                ),
                'waktu' => array(
                  array(
                    'hari' => "Senin - Jum'at",
                    'jam' => "08:00am - 05:00pm",
                  ),
                  array(
                    'hari' => "Sabtu",
                    'jam' => "Tutup",
                  ),
                  array(
                    'hari' => "Minggu",
                    'jam' => "Tutup",
                  ),
                ),
                'metode_pembayaran' =>  array(
                  array(
                    'img' => "/assets/dana.png",
                    'alt' => "Dana",
                  ),
                  array(
                    'img' => "/assets/ovo.png",
                    'alt'=> "OVO",
                  ),
                  array(
                    'img'=>"/assets/indomaret.png",
                    'alt'=> "Indomaret",
                  ),
                  array(
                    'img'=> "/assets/alfamart.png",
                    'alt'=> "Alfamart",
                  ),
                  array(
                    'img'=> "/assets/bca.png",
                    'alt'=> "Bank Central Asia",
                  ),
                  array(
                    'img'=>"/assets/btn.png",
                    'alt'=> "Bank Tabungan Negara",
                  ),
                ),
        ),
        'footer_bottom' => 'Makersware Service @ 2020 All rights reserved'
          );
        $layout['navbar'] = json_encode($navbar);
        $layout['carousel'] = json_encode($carousel);
        $layout['MCarousel'] = json_encode($MCarousel);
        $layout['footer'] = json_encode($footer);
        if(!$layout->save()){
          $this->status_code = 500;
          $this->message = ['status' => 'error'];
        }else{
          $this->status_code = 200;
          $this->message = ['status' => 'success'];
        }
        return response()->json($this->message,$this->status_code);
    }
}

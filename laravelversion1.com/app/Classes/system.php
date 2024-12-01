<?php
namespace App\Classes;


class system{

public function config(){
    $data['homepage'] =[
      'label' =>'Thông tin chung',
      'description'=>'Cài đặt đầy đủ thông tin chung của website.Tên thương hiệu Websit,logo ,favicon...v..v',
      'value'=>[
        'company' =>['type' =>'text','label' =>'Tên công ty'],
        'brand' =>['type' =>'text','label' =>'Tên Thương hiệu'],
        'slogan' =>['type' =>'text','label' =>'Slogan'],
        'logo' =>['type' =>'images','label' =>'Logo Website','title' =>'click vào ô phía dưới để tải logo'],
        'favicon' =>['type' =>'images','label' =>'Favicon','title' =>'click vào ô phía dưới để tải logo'],

        'copyright' =>['type' =>'text','label' =>'Copyright'],
        'website' =>['type' =>'select' ,
        'label' =>'tình trạng website',
        'option' =>[
            'open' =>'Mở của website',
            'close' =>'Website đang bảo trì'
        ]
        ],
        'short_intro' =>['type'=>'editor' , 'label' =>'giới thiệu ngắn']
      ]   
    ];
    $data['contact'] =[
        'label' =>'Thông tin chung',
        'description'=>'Cài đặt thông tin liên hệ của website ví dụ : Địa chỉ công ty , 
         Văn phòng giao dịch ,HotLine,Bản đồ, vv.v..',
        'value'=>[
          'office' =>['type' =>'text','label' =>'Địa chỉ Công Ty'],

          'address' =>['type' =>'text','label' =>'Văn Phòng giao dịch'],
          'hotline' =>['type' =>'text','label' =>'HotLine'],
          'technical_phone' =>['type' =>'text','label' =>'HotLine Kỹ Thuật'],
          'sell_phone' =>['type' =>'text','label' =>'HotLine Kinh doanh'],
          'phone' =>['type' =>'text','label' =>'Số cố định'],
          'fax' =>['type' =>'text','label' =>'Fax'],
          'email' =>['type' =>'text','label' =>'Email'],
          'tax' =>['type' =>'text','label' =>'Mã số thuế'],
          'map' =>['type' =>'textarea',
          'label' =>'Bản đồ',
          'link' =>[ 'text' =>'Hướng dẫn thiết lập bản đồ',
                      'href' =>'https://help.socio.events/vi/articles/3409496-h%C6%B0%E1%BB%9Bng-d%E1%BA%ABn-thi%E1%BA%BFt-l%E1%BA%ADp-tinh-nang-b%E1%BA%A3n-d%E1%BB%93',
                      'target'=>'__blank'
          
           ]],
     
           
          



         
        ]   
      ];
      $data['seo'] =[
        'label' =>'Cấu hình SEO  dành cho trang chủ',
        'description'=>'Cài đặt đầy đủ thông tin về SEO của website.Bảo gồm tiêu đề SEO,từ khóa SEO , Mô tả SEO , Meta images',
        'value'=>[
          'meta_title' =>['type' =>'text','label' =>'Tiêu đề SEO'],
          'meta_keyword' =>['type' =>'text','label' =>'Từ khóa SEO'],
          'meta_description' =>['type' =>'textarea','label' =>'Mô tả SEO'],
          'meta_images' =>['type' =>'images','label' =>'ảnh SEO'],

        
        ]   
      ];
    return $data;

}
}

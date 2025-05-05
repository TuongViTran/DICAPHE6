<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Shopimage;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed bảng user
        DB::table('users')->insert([
            [
                'full_name' => 'owner1',
                'email' => 'owner1@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'owner',
                'gender' => 'male',
                'phone' => '0912345678',
                'avatar_url' => 'c1.jpg',
                'remember_token' => Str::random(100),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'owner2',
                'email' => 'owner2@gmailcom',
                'password' => bcrypt('12345678'),
                'role' => 'owner',
                'gender' => 'male',
                'phone' => '0934567890',
               'avatar_url' => 'c2.jpg',
                'remember_token' => Str::random(100),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [  'full_name' => 'owner3',
                'email' => 'owner3@gmailcom',
                'password' => bcrypt('12345678'),
                'role' => 'owner',
                'gender' => 'male',
                'phone' => '0934567890',
               'avatar_url' => 'c3.jpg',
                'remember_token' => Str::random(100),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [  'full_name' => 'owner4',
                'email' => 'owner4@gmailcom',
                'password' => bcrypt('12345678'),
                'role' => 'owner',
                'gender' => 'male',
                'phone' => '0934567890',
                'avatar_url' => 'c4.jpg',
                'remember_token' => Str::random(100),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [  'full_name' => 'owner5',
                'email' => 'owner5@gmailcom',
                'password' => bcrypt('12345678'),
                'role' => 'owner',
                'gender' => 'male',
                'phone' => '0934567890',
                'avatar_url' => 'c5.jpg',
                'remember_token' => Str::random(100),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [  'full_name' => 'owner6',
                'email' => 'owner6@gmailcom',
                'password' => bcrypt('12345678'),
                'role' => 'owner',
                'gender' => 'female',
                'phone' => '0934567890',
                'avatar_url' => 'c6.jpg',
                'remember_token' => Str::random(100),
                'created_at' => now(),
                'updated_at' => now(),
            ],
                
            [
                'full_name' => 'admin1',
                'email' => 'admin1@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'admin',
                'gender' => 'male',
                'phone' => '0923456789',
                'avatar_url' => 'a1.jpg',
                'remember_token' => Str::random(100),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'user1',
                'email' => 'user1@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'user',
                'gender' => 'male',
                'phone' => '0934567890',
                'avatar_url' =>'u1.jpg' ,
                'remember_token' => Str::random(100),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // 2. Seed bảng social_network
        // DB::table('social_network')->insert([
        //     [ 'platform' => 'Facebook', 'url' => 'https://www.facebook.com/', 'created_at' => now()],
        //     [ 'platform' => 'Instagram', 'url' => 'https://www.instagram.com/', 'created_at' => now()],
        // ]);

        // 3. Seed bảng styles
        DB::table('styles')->insert([
            [
                'style_name' => 'Truyền Thống',
                'description' => 'Quán cà phê truyền thống – mang nét cổ kính, gần gũi và mộc mạc.',
                'created_at' => now()
            ],
            [
                'style_name' => 'Hiện Đại',
                'description' => 'Quán cà phê hiện đại – thiết kế tối giản, không gian mở, công nghệ cao.',
                'created_at' => now()
            ],
            [
                'style_name' => 'Công sở',
                'description' => 'Quán cà phê công sở – phù hợp làm việc, yên tĩnh, có bàn dài và ổ điện.',
                'created_at' => now()
            ],
            [
                'style_name' => 'Nhà Máy',
                'description' => 'Quán cà phê nhà máy – không gian rộng, phong cách công nghiệp.',
                'created_at' => now()
            ],
        ]);
        

      
        // 4. Seed bảng addresses
        DB::table('addresses')->insert([
            [ // Dưới 1km
                'street'      => '703 Âu Cơ',
                'ward'        => 'Hòa Khánh Bắc',
                'district'    => 'Liên Chiểu',
                'city'        => 'Đà Nẵng',
                'postal_code' => '550000',
                'country'     => 'Vietnam',
                'latitude'    => 16.078861340698975,
                'longitude'   => 108.12719055414928,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // Khoảng 2km
                'street'      => '02 Lê Duẩn',
                'ward'        => 'Hòa Thuận Đông',
                'district'    => 'Hải Châu',
                'city'        => 'Đà Nẵng',
                'postal_code' => '550000',
                'country'     => 'Vietnam',
                'latitude'    => 16.460000,
                'longitude'   => 107.575000,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // Khoảng 3km
                'street'      => '03 Nguyễn Chí Thanh',
                'ward'        => 'Thạch Thang',
                'district'    => 'Hải Châu',
                'city'        => 'Đà Nẵng',
                'postal_code' => '550000',
                'country'     => 'Vietnam',
                'latitude'    => 16.455000,
                'longitude'   => 107.590000,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // Khoảng 5km
                'street'      => '04 Trần Cao Vân',
                'ward'        => 'Tam Thuận',
                'district'    => 'Thanh Khê',
                'city'        => 'Đà Nẵng',
                'postal_code' => '550000',
                'country'     => 'Vietnam',
                'latitude'    => 16.440000,
                'longitude'   => 107.600000,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // Khoảng 7km
                'street'      => '05 Nguyễn Hữu Thọ',
                'ward'        => 'Khuê Trung',
                'district'    => 'Cẩm Lệ',
                'city'        => 'Đà Nẵng',
                'postal_code' => '550000',
                'country'     => 'Vietnam',
                'latitude'    => 16.430000,
                'longitude'   => 107.620000,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
        
        
         // 5. Seed bảng coffeeshop
         DB::table('coffeeshop')->insert([
            [
                'shop_name' => '𝐑𝐮𝐬𝐭𝐢𝐜 𝐓𝐞𝐚 & 𝐂𝐨𝐟𝐟𝐞𝐞',
                'phone' => '0909123456',
                'user_id' => 1,
                'description' => 'Không gian thoải mái, lý tưởng cho làm việc,quán gần đây.',
                'address_id' => 1,
                'status' => 'Đang mở cửa',
                'opening_time' => '07:00:00',
                'closing_time' => '22:00:00',
                'parking' => 'Chỗ đậu xe miễn phí',
                'wifi_password' => 'thecoffee123',
                'hotline' => '19001001',
                'reviews_avg_rating' => 4.5,
                'min_price' =>25,
                'max_price' => 40,
                'styles_id' => 1,
                // 'social_network_id' => 1,
                'cover_image' =>'q1_cover.jpg',
                'image_1' => 'q1_image1.jpg',
                'image_2' => 'q1_image2.jpg',
                'image_3' => 'q1_image3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shop_name' => 'Chuyện Coffee',
                'phone' => '0909234567',
                'user_id' => 2,
                'description' => 'Chuyện nép mình ở một góc phố bình lặng, dưới hàng cây cao lớn, mang nét Việt giản đơn và ấm áp. Gian nhà mái ngói của 𝑪𝒉𝒖𝒚𝒆̣̂𝒏 đã ngập tràn không khí Xuân,
                 trang trí đơn giản mà hợp vibes, với đầy sắc đỏ may mắn,Không gian thoải mái',
                'address_id' => 2,
                'status' => 'Đang mở cửa',
                'opening_time' => '08:00:00',
                'closing_time' => '23:00:00',
                'parking' => 'Chỗ đậu xe rộng rãi, miễn phí',
                'wifi_password' => 'chuyen456',
                'hotline' => '19001002',
                'reviews_avg_rating' => 4.2,
                'min_price' => 30,
                'max_price' => 45,
                'styles_id' => 1,
                // 'social_network_id' => 2,
                'cover_image' =>'q2_cover.jpg',
                'image_1' => 'q2_image1.jpg',
                'image_2' => 'q2_image2.jpg',
                'image_3' => 'q2_image3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shop_name' => 'Gé',
                'phone' => '0909345678',
                'user_id' => 3,
                'description' =>'mang hơi thở industrial đầy cá tính, kết cấu không gian đơn giản từ ngôi nhà cũ được cải tạo, thông phá; nội thất tối giản, gam màu - vật liệu mạnh mẽ. Tuy nhiên tổng thể phong cách có phần quen thuộc, 
                  chưa đẫm nét sáng tạo, điểm nổi bật riêng',
                'address_id' => 3,
                'status' => 'Đang mở cửa',
                'opening_time' => '06:30:00',
                'closing_time' => '21:30:00',
                'parking' => 'Không',
                'wifi_password' => 'phuclong789',
                'hotline' => '19001003',
                'reviews_avg_rating' => 4.0,
                'min_price' => 50,
                'max_price' => 65,
                'styles_id' => 2,
                // 'social_network_id' => 2,
                'cover_image' =>'q3_cover.jpg',
                'image_1' => 'q3_image1.jpg',
                'image_2' => 'q3_image2.jpg',
                'image_3' => 'q3_image3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shop_name' => 'The Third House ',
                'phone' => '0909456789',
                'user_id' => 4,
                'description' => 'Tọa độ mới đầy nổi bật trên con đường dọc bờ sông Hàn - ThìLà mang một nét riêng độc đáo, sáng tạo, chứa đựng hồn Việt nhẹ nhàng. Không gian quán vừa phải, mặt tiền trải dài cùng đường nét kiến trúc tạo cảm giác to lớn. Trải nghiệm ThìLà ta cảm nhận được sự đầy tư chỉn chu từ câu chuyện đến vật liệu, nội thất, 
                ánh sáng,...; sự hài hòa giữa cũ và mới đem lại sự thư thái, dễ chịu',
                'address_id' => 4,
                'status' => 'Đã đóng cửa',
                'opening_time' => '09:00:00',
                'closing_time' => '21:00:00',
                'parking' => 'Có',
                'wifi_password' => 'urban456',
                'hotline' => '19001004',
                'reviews_avg_rating' => 3.8,
                'min_price' => 55,
                'max_price' => 70,
                'styles_id' => 1,
                // 'social_network_id' => 1,
                'cover_image' =>'q4_cover.jpg',
                'image_1' => 'q4_image1.jpg',
                'image_2' => 'q4_image2.jpg',
                'image_3' => 'q4_image3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shop_name' => 'Bông ',
                'phone' => '0909456789',
                'user_id' => 5,
                'description' => 'Bòng café được tách khỏi sự nhộn nhịp của một con đường trung tâm thành phố bằng khoảng sân vườn nhỏ trước nhà,
                 bạn sẽ ngạc nhiên bởi không gian rộng rãi bên trong khi bước qua lối vào mặt tiền khá khiêm tốn',
                'address_id' => 2,
                'status' => 'Đã đóng cửa',
                'opening_time' => '09:00:00',
                'closing_time' => '21:00:00',
                'parking' => 'Có',
                'wifi_password' => 'urban456',
                'hotline' => '19001004',
                'reviews_avg_rating' => 3.8,
                'min_price' => 55,
                'max_price' => 70,
                'styles_id' => 3,
                // 'social_network_id' => 1,
                'cover_image' =>'q5_cover.jpg',
                'image_1' => 'q5_image1.jpg',
                'image_2' => 'q5_image2.jpg',
                'image_3' => 'q5_image3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shop_name' => 'Vật Thể ',
                'phone' => '0909456789',
                'user_id' => 6,
                'description' => 'vậtthể có thiết kế theo phong cách triển lãm được đôi bạn trẻ đặt hết tâm huyết, 
                sự sáng,Không gian thoải mái.Tầng 1 của vậtthể là không gian dành cho cà phê, trà-bánh: có tông màu vàng chủ đạo',
                'address_id' => 2,
                'status' => 'Đang mở cửa',
                'opening_time' => '09:00:00',
                'closing_time' => '21:00:00',
                'parking' => 'Có',
                'wifi_password' => 'urban456',
                'hotline' => '19001004',
                'reviews_avg_rating' => 3.8,
                'min_price' => 75,
                'max_price' => 79,
                'styles_id' => 4,
                // 'social_network_id' => 1,
                'cover_image' =>'q6_cover.jpg',
                'image_1' => 'q6_image1.jpg',
                'image_2' => 'q6_image2.jpg',
                'image_3' => 'q6_image3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
        
        

        DB::table('menu')->insert([
            ['shop_id' => 1, 'item_name' => 'Menu1', 'image_url' => 'menu1.jpg', 'price' => 25000, 'description' => 'Cà phê nguyên chất, đậm đà hương vị.', 'status' => 'Available', 'created_at' => now(), 'updated_at' => now()],
            ['shop_id' => 2, 'item_name' => 'Menu2', 'image_url' => 'menu2.jpg', 'price' => 35000, 'description' => 'Trà sữa thơm ngon, kết hợp trân châu dai giòn.', 'status' => 'Available', 'created_at' => now(), 'updated_at' => now()],
            ['shop_id' => 3, 'item_name' => 'Menu3', 'image_url' => 'menu3.jpg', 'price' => 30000, 'description' => 'Nước ép trái cây tươi mát, bổ dưỡng.', 'status' => 'Available', 'created_at' => now(), 'updated_at' => now()],
            ['shop_id' => 4, 'item_name' => 'Menu4', 'image_url' => 'menu4.jpg', 'price' => 40000, 'description' => 'Bánh ngọt thơm ngon, hấp dẫn.', 'status' => 'Available', 'created_at' => now(), 'updated_at' => now()],
            ['shop_id' => 5, 'item_name' => 'Menu5', 'image_url' => 'menu5.jpg', 'price' => 45000, 'description' => 'Sinh tố trái cây tươi ngon, bổ dưỡng.', 'status' => 'Available', 'created_at' => now(), 'updated_at' => now()],
            ['shop_id' => 6, 'item_name' => 'Menu6', 'image_url' => 'menu6.jpg', 'price' => 50000, 'description' => 'Bánh mì kẹp thịt thơm ngon, hấp dẫn.', 'status' => 'Available', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // DB::table('event')->insert([
        //     ['shop_id' => 1, 'event_name' => 'Đêm nhạc Acoustic', 'description' => 'Thưởng thức âm nhạc sống động với ban nhạc trẻ.', 'event_date' => now()->addDays(5), 'location' => 'Cà Phê Sáng', 'created_at' => now(), 'updated_at' => now()],
        //     ['shop_id' => 2, 'event_name' => 'Workshop Pha Chế', 'description' => 'Học cách pha chế cà phê chuyên nghiệp.', 'event_date' => now()->addDays(10), 'location' => 'Cafe Phố', 'created_at' => now(), 'updated_at' => now()],
        // ]);

        // DB::table('tablereservation')->insert([
        //     ['user_id' => 1, 'shop_id' => 1, 'event_id' => 1, 'number_of_people' => 2, 'reservation_time' => now()->addDays(5), 'table_location' => 'Góc nhỏ', 'special_request' => 'Không', 'price' => 50000, 'status' => 'Confirmed', 'created_at' => now(), 'updated_at' => now()],
        //     ['user_id' => 2, 'shop_id' => 2, 'event_id' => 2, 'number_of_people' => 4, 'reservation_time' => now()->addDays(10), 'table_location' => 'Góc yên tĩnh', 'special_request' => 'Không', 'price' => 70000, 'status' => 'Pending', 'created_at' => now(), 'updated_at' => now()],
        // ]);

        DB::table('review')->insert([
            ['user_id' => 1, 'shop_id' => 1, 'rating' => 5, 'content' => 'Quán đẹp, nhân viên thân thiện.','img_url'=>'https://example.com/images/cafe_pho_1.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'shop_id' => 2, 'rating' => 4, 'content' => 'Không gian quán đẹp, giá cả hợp lý.','img_url'=>'https://example.com/images/cafe_pho_2.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // DB::table('promotion')->insert([
        //     ['shop_id' => 1, 'title' => 'Giảm 20% cho sinh viên', 'description' => 'Ưu đãi đặc biệt cho sinh viên khi mang theo thẻ.', 'discount_percent' => 20.00, 'discount_amount' => 10000, 'start_date' => now(), 'end_date' => now()->addDays(7), 'created_at' => now(), 'updated_at' => now()],
        //     ['shop_id' => 2, 'title' => 'Mua 2 tặng 1', 'description' => 'Mua hai ly bất kỳ, nhận ngay một ly miễn phí.', 'discount_percent' => 33.33, 'discount_amount' => 35000, 'start_date' => now(), 'end_date' => now()->addDays(10), 'created_at' => now(), 'updated_at' => now()],
        // ]);
        DB::table('post')->insert([
            [
                'user_id' => 1,
                'title' => '31 quán cà phê đẹp ở Sài Gòn “đi một lần post ảnh một tuần”',
                'description' => '31 quán cà phê đẹp ở Sài Gòn có đủ mọi phong cách từ hiện đại, phóng khoáng cho đến vintage, để bạn lựa chọn cho một buổi chiều không biết “đi đâu về đâu”.',
                'content' => '31 quán cà phê đẹp ở Sài Gòn có đủ mọi phong cách từ hiện đại, phóng khoáng cho đến vintage,
                 để bạn lựa chọn cho một buổi chiều không biết “đi đâu về đâu”.',
                'image_url' => 'post1.jpg',
                'status' => 'Published',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'title' => 'Bật mí top 17 quán cafe ĐẸP ở Sài Gòn nên ghé ít nhất một lần',
                'description' => 'Quán cafe đẹp ở Sài Gòn là từ khóa được nhiều du khách tìm kiếm nhất mỗi khi ghé thăm Sài thành. Bên cạnh cảnh đẹp và nền ẩm thực phong phú,
                có lẽ những quán cafe “chất” đã trở thành một phần không thể thiếu của nơi đây.',
                'content' => 'Quán cafe đẹp ở Sài Gòn là từ khóa được nhiều du khách tìm kiếm nhất mỗi khi ghé thăm Sài thành. Bên cạnh cảnh đẹp và nền ẩm thực phong phú, 
                có lẽ những quán cafe “chất” đã trở thành một phần không thể thiếu của nơi đây.',
                'image_url' => 'post2.jpg',
                'status' => 'Published',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1,
                'title' => 'Top 20 quán cafe đẹp ở Sài Gòn đẹp say đắm lòng người',
                'description' => 'Sài Gòn thành phố nhộn nhịp tấp nập có nhiều địa điểm vui chơi, giải trí, thư giãn. Nơi đây nổi tiếng với nhiều quán cà phê nổi tiếng ngon, view sống ảo cực đỉnh, sau đây hãy cùng Reviewvilla.vn tìm hiểu các quán cafe đẹp ở Sài Gòn nhé!',
                'content' => 'Sài Gòn thành phố nhộn nhịp tấp nập có nhiều địa điểm vui chơi, giải trí, thư giãn. Nơi đây nổi tiếng với nhiều quán cà phê nổi tiếng ngon, view sống ảo cực đỉnh, sau đây hãy cùng Reviewvilla.vn tìm hiểu các quán cafe đẹp ở Sài Gòn nhé!',
                'image_url' => 'post3.jpg',
                'status' => 'Published',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1,
                'title' => 'Ghé 9 quán cà phê vintage ở Sài Gòn',
                'description' => 'Những quán cà phê vintage luôn có sức hút riêng không thể cưỡng lại. Đó là sự pha trộn giữa cổ điển và phong cách đương đại, tạo nên một không gian tràn đầy cảm xúc cho những coffee-holic Sài Thành.',
                'content' => 'Những quán cà phê vintage luôn có sức hút riêng không thể cưỡng lại. Đó là sự pha trộn giữa cổ điển và phong cách đương đại, tạo nên một không gian tràn đầy cảm xúc cho những coffee-holic Sài Thành.
                 Hãy theo chân Traveloka tìm đến 9 quán cà phê vintage Sài Gòn đẹp và cực đậm chất retro nhé!',
                'image_url' => 'post4.webp',
                'status' => 'Published',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1,
                'title' => 'Top quán cà phê “ẩn mình” giữa lòng Hà Nội xưa',
                'description' => 'Giữa phố cổ đông đúc, có những quán cà phê nhỏ mang đậm chất Hà Nội xưa, rất yên tĩnh và hoài niệm.',
                'content' => 'Danh sách những quán cà phê mang phong cách hoài cổ, nằm nép mình trong những con ngõ nhỏ của Hà Nội – nơi lý tưởng để chill và hoài niệm.',
                'image_url' => 'post5.webp',
                'status' => 'Published',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 3,
                'title' => 'Check-in 5 quán cà phê Đà Lạt đẹp như tranh vẽ',
                'description' => 'Không gian đồi núi, mây mù và những quán cà phê chill đậm chất Đà Lạt đang chờ bạn khám phá.',
                'content' => '5 quán cà phê có view thung lũng, nhà gỗ, hoặc phong cách Scandinavian giữa lòng Đà Lạt, rất được giới trẻ săn đón để “sống ảo”.',
                'image_url' => 'post6.jpg',
                'status' => 'Published',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 4,
                'title' => 'Các quán cà phê đẹp ở Đà Nẵng với view biển mát rượi',
                'description' => 'Bạn vừa muốn uống cà phê vừa được ngắm biển? Đà Nẵng có những địa điểm tuyệt vời dành cho bạn.',
                'content' => 'Tổng hợp những quán cà phê nằm sát bãi biển Mỹ Khê, nơi bạn có thể chill với bạn bè dưới ánh nắng và gió biển mát lạnh.',
                'image_url' => 'post7.webp',
                'status' => 'Published',
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            [
                'user_id' => 2,
                'title' => 'Những quán cà phê decor độc đáo tại Hội An',
                'description' => 'Cà phê Hội An nổi bật với sự kết hợp giữa kiến trúc cổ và decor hiện đại, mang đến trải nghiệm cực kỳ “artsy”.',
                'content' => 'Danh sách các quán cà phê có thiết kế độc đáo, tường vàng, bàn gỗ, đèn lồng – rất đúng chất Hội An nhưng lại pha chút hiện đại, cá tính.',
                'image_url' => 'post9.jpg',
                'status' => 'Published',
                'created_at' => now(),
                'updated_at' => now()
            ]
        
        ]);

        DB::table('comment')->insert([
            ['user_id' => 1, 'post_id' => 1, 'content' => 'Quán đẹp quá, chắc chắn sẽ ghé lại!', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'post_id' => 2, 'content' => 'Chắc chắn sẽ ghé qua Cafe Phố để check-in!', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('favoriteshop')->insert([
            ['user_id' => 1, 'shop_id' => 1, 'saved_at' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'shop_id' => 2, 'saved_at' => now(), 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('recentsearches')->insert([
            ['user_id' => 1, 'keyword' => 'Cà phê ngon gần đây', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'keyword' => 'Quán cà phê yên tĩnh', 'created_at' => now(), 'updated_at' => now()],
        ]);
      
        DB::table('notification')->insert([
            ['user_id' => 1, 'type' => 'order', 'message' => 'Đơn hàng của bạn đã được xác nhận.', 'is_read' => false, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'type' => 'promotion', 'message' => 'Bạn có khuyến mãi mới từ quán yêu thích.', 'is_read' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('likes')->upsert(
            [
                ['user_id' => 1, 'review_id' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['user_id' => 2, 'review_id' => 2, 'created_at' => now(), 'updated_at' => now()],
                ['user_id' => 1, 'review_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ],
            ['user_id', 'review_id'], 
            ['created_at', 'updated_at'] 
        );
        
        

    }
}

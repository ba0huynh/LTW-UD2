<footer class="footer">
    <div class="left-footer">
        <h1 class="text-red">Book</h1>
        <p class="mt-4">Chuyên cung cấp sách giáo trình, văn phòng phẩm, đồ dùng học tập</p>
        <p>Book.com nhận đặt hàng trực tuyến và giao hàng tận nơi. KHÔNG hỗ trợ đặt mua và nhận hàng trực tiếp tại văn phòng cũng như tất cả Hệ Thống Fahasa trên toàn quốc.</p>
        <div class="social-icons"> 
            <a href="#" target="_blank">Download on Android <i class="fa-brands fa-google-play"></i></a>
            <a href="#" target="_blank">Download on iOS <i class="fa-brands fa-app-store-ios"></i></a>
        </div>    
    </div>
    <div class="right-footer">
        <div class="service">
            <h1 class="font-bold">Dịch vụ</h1>
            <ul>
                <li>Điều khoản sử dụng</li>
                <li>Chính sách bảo mật thông tin cá nhân</li>
                <li>Chính sách bảo mật thanh toán</li>
                <li>Giới thiệu</li>
                <li>Hệ thống trung tâm - nhà sách</li>
            </ul>
        </div>
        
        <div class="help">
            <h1 class="font-bold">Hỗ trợ</h1>
            <ul>
                <li>Chính sách đổi - trả - hoàn tiền</li>
                <li>Chính sách bảo hành - bồi hoàn</li>
                <li>Chính sách vận chuyển</li>
                <li>Chính sách khách sỉ</li>
            </ul>
        </div>
        
        <div class="my-account">
            <h1 class="font-bold">Tài khoản của tôi</h1>
            <ul>
                <li>Đăng nhập/Tạo mới tài khoản</li>
                <li>Thay đổi địa chỉ khách hàng</li>
                <li>Chi tiết thanh toán</li>
                <li>Lịch sử mua hàng</li>
            </ul>
        </div>
        
        <div class="contact">
            <h1 class="font-bold">Liên hệ</h1>
            <ul>
                <li><i class="fa-solid fa-location-dot"></i> 123-Đường abc - Q.x -TP.HCM</li>
                <li><i class="fa-solid fa-envelope"></i> abcxyz#gmail.com</li>
                <li><i class="fa-solid fa-phone"></i> 1900******</li>
            </ul>
        </div>
    </div>
</footer>
<style>
    .footer {
    background-color: white;
    color: #000;
    text-align: center;
    padding: 24px 0;
    display: flex;
    flex-wrap: wrap;
    margin: 10px;
}

.left-footer {
    width: 30%;
    text-align: left;
    padding: 20px;
    justify-content: space-between;

}

.text-red {
    color: #ef4444;
    font-size: 24px;
    font-weight: bold;
}

.social-icons {
    display: flex;
    gap: 15px;
    margin-top: 10px;
}

.social-icons a {
    color: #000;
    text-decoration: none;
}

.right-footer {
    border-left: 3px solid #555;
    width: 55%;
    display: flex;
    padding-left: 20px;
}
.right-footer > div {
    width: 45%;
    margin-bottom: 20px;
    text-align: left;
}

.font-bold {
    font-weight: bold;
    font-size: 18px;
}

ul {
    list-style: none;
    padding: 0;
}

ul li {
    margin-top: 5px;
}

.contact i {
    margin-right: 5px;
}

@media (max-width: 768px) {
    .footer {
        flex-direction: column;
        text-align: center;
    }

    .left-footer, .right-footer {
        width: 100%;
        padding: 10px;
    }

    .right-footer {
        flex-direction: column;
    }
}

</style>
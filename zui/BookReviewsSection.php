<section class="bg-white rounded-lg p-6 w-full">
    <h2>Đánh giá sản phẩm</h2>
    <div class="flex flex-row items-center">
        <div class="flex flex-row gap-4">

            <div class="flex flex-col items-center">
                <div class="text-3xl"><span class="text-6xl">0</span>/5</div>

                <div class="flex flex-row">

                    <?php

                    $amount = 5;
                    while ($amount > 0) {
                        echo '
                <img src="../images/yellow-star.png" class="w-4 h-4" alt="">
                
                ';
                        $amount--;
                    } ?>
                </div>
                <p class="text-grey">(0 đánh giá)</p>
            </div>
            <div class="flex flex-col">
                <?php
                $amount = 5;
                while ($amount > 0) {
                    echo "
                                    <div class='flex flex-row items-center gap-4'>$amount sao
                    <div class='w-[200px] relative  h-2'>

                        <div class=' absolute left-0 w-full h-full bg-[#E3E5E5] rounded-full'></div>
                        <div class=' absolute left-0 w-[50%] h-full bg-[#F6A500] rounded-full'></div>
                    </div>
                    0%
                </div>
                    ";
                    $amount--;
                }
                ?>

            </div>
        </div>
        <div class="flex flex-row items-center flex-1 justify-center">

            <p>
                Chỉ có thành viên mới có thể viết nhận xét. Vui lòng 
                <a class="text-blue-500" href="/">đăng nhập</a> hoặc <a class="text-blue-500" href="/">đăng ký<a>.</p>
        </div>
    </div>
    <div class="w-full h-[1px] bg-gray-200 my-[10px]"></div>
    <div class="flex flex-col">
        <div class="flex flex-row">
            <div class="flex flex-col flex-1">
                <p class="text-md">Bao Huynh</p>
                <p class="text-sm text-gray-500">11/06/2025</p>
            </div>
            <div class="flex flex-col gap-1 flex-5">
                <div class="flex flex-row">

                    <?php

                    $amount = 5;
                    while ($amount > 0) {
                        echo '
<img src="../images/yellow-star.png" class="w-3 h-3" alt="">

';
                        $amount--;
                    } ?>
                </div>
                <p>hihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihihi</p>
            </div>
        </div>
    </div> 
</section>

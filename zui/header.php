
    <div>
        <div>
            <div class="header">
                <div class="headerLeft"></div>
                <div class="headerCenter">
                    <div class="logoHeader">
                        <div>
                            <img id="logo" src="./images/forHeader/logo.jpg" alt="">
                        </div>

                        <div>
                            <img id="menuLogo" src="./images/forHeader/menuHeader.png" alt="">
                            <i class="fa-light fa-angle-down"></i>
                        </div>
                    </div>
                    <div class="inputHeader">
                        <input type="text" placeholder="">
                        <div>
                            <i class="fa-light fa-magnifying-glass"></i>
                        </div>
                    </div>
                    <div class="inforHeader">
                        <div>
                            <img id="bell" src="./images/forHeader/bell.png" alt=""><br>
                            Thông Báo
                        </div>
                        <div>
                            <img id="cart" src="./images/forHeader/cart.png" alt=""><br>
                            <?php
                            $userId = $_SESSION('user_id');
                            if(isset($userId)){
                                $queryCountCart=`select count(*) from cart,user where cart. `;
                                //const count_number_cart
                            }
                            ?>
                            Giỏ Hàng
                        </div>
                        <div>
                            <?php
                            if (isset($_SESSION['userId'])){
                                $useIdr=$_SESSION['userId'];
                            ?>
                            <img id="account" src="./images/forHeader/account.png" alt=""> <br>
                            <a href="taikhoan.php?/userId=<?php echo $userId?>" >Tài khoản</a>
                            <?php }
                            else{
                            ?>
                            <img id="account" src="./images/forHeader/account.png" alt=""> <br>
                            <a href="nottaikhoan.php" >Tài khoản</a>
                            <?php }?>
                            

                        </div>
                        <div id="vietNam" >
                            <img  src="./images/forHeader/vietNam.png" alt="">

                            <i class="fa-light fa-angle-down"></i>
                        </div>
                    </div>
                </div>
                <div class="headerRight"></div>
            </div>
            <div class="menuContent">
                <div class="sideBarMenu">
                    <?php
                    for($i=6;$i<13;$i++){
                    ?>
                    <div class="tablinks " data-id="<?php echo $i;?>">Lớp <?php echo $i?></div>
                    <?php
                    }
                    ?>
                    <script>
                        document.querySelectorAll(".tablinks").forEach(tab=>{
                            tab.addEventListener("mouseenter",function(){
                                let Class=this.dataset.id;
                                openTab(this,Class);
                            })
                        })
                        function openTab(tab,Class){

                            const Tablinks=document.querySelectorAll(".tablinks");
                            for(let i=0;i<Tablinks.length;i++){
                                Tablinks[i].className=Tablinks[i].className.replace(" onTab","");
                            }
                            tab.classList.add("onTab");
                        }
                    </script>

                </div>
                <div class="line"></div>
                <div style="width: 100%;">
                    <div> 
                        <div><img src="./images/forHeader/menuBook.png" alt="">
                    </div>SÁCH TRONG NƯỚC</div>
                    <div class="detailMenu">
                        <!-- div*3 -->
                    </div>
                    <script>
                        const detailMenu=document.querySelector(".detailMenu");
                        const tablinks=document.querySelectorAll(".tablinks");
                        tablinks.forEach(tab=>{
                            tab.addEventListener("mouseenter",function(){
                                const Class=this.dataset.id;
                                fetch(`contentMenu.php/?Class=${Class}`).
                                then(response=>response.text()).
                                then(data=>{
                                    detailMenu.innerHTML=data;
                                })
                            })
                        })

                    </script>
                </div>
            </div>
        </div>
    </div>
    <script>
                        document.getElementById("menuLogo").addEventListener("mouseenter",function(){
                            document.querySelector(".menuContent").style.display="flex";
                        })
                        document.querySelector(".menuContent").addEventListener("mouseenter",function(){
                            document.querySelector(".menuContent").style.display="flex";
                        })
                        document.querySelector(".menuContent").addEventListener("mouseleave",function(){
                            document.querySelector(".menuContent").style.display="none";
                        })
                        document.getElementById("menuLogo").addEventListener("mouseleave",function(){
                            document.querySelector(".menuContent").style.display="none";
                        })
                        </script>

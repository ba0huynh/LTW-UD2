import React from "react";
import "./ProductDetail.css";
const ProductDetail = () => {
  return (
    <div className="main">
      <div className="product-detail">
        <section className="left-product-details">
            <img src="" alt="" />
        </section>
        <section className="right-product-details">
            <h1>
                Tây du kí
            </h1>
            <div className="flex flex-row gap-2.5 items-center">
                <p className="text-[#c92127] font-bold text-[32px]">50.000đ</p>
                <p className="old-price">70.000đ</p>
                <div className="discount-percent">-15%</div>
            </div>
        </section>
      </div>
    </div>
  );
};

export default ProductDetail;

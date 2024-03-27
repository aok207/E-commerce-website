import showToast from "./Toast";
import axios from "axios";
import { incrementCartCount } from "../store";

export const handleBookmark = (id, isBookmarked, setIsBookmarked, changeProductsList, currentProductList) => {
  if (!isBookmarked) {
      axios
          .post("/api/bookmark-product", { id: id })
          .then(function (res) {
              setIsBookmarked(true);
              showToast(res.data.message, "green");
          })
          .catch((err) => {
              showToast(err.response.data.message, "red");
          });
  } else {
      axios
          .post("/api/unbookmark-product", { id: id })
          .then(function (res) {
              setIsBookmarked(false);
              if (changeProductsList && currentProductList.length !== 0) {
                  changeProductsList(
                      currentProductList.filter(
                          (product) => product.product.id !== id
                      )
                  );
              }
              showToast(res.data.message, "green");
          })
          .catch((err) => {
              showToast(err, "red");
          });
  }
};

export const addToCart = (id, setIsInCart, dispatch) => {
  axios
      .post("/api/add-to-cart", { product_id: id })
      .then(function (res) {
          setIsInCart(true);
          showToast(res.data.message, "green");
          dispatch(incrementCartCount());
      })
      .catch((err) => {
          showToast(err.response.data.message, "red");
      });
};
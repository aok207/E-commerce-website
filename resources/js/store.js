import { configureStore, createSlice } from '@reduxjs/toolkit';

// Define a slice for managing cart count
const cartSlice = createSlice({
  name: 'cart',
  initialState: {
    count: parseInt(localStorage.getItem('cart_items_count') === "null" ? 0 : localStorage.getItem('cart_items_count')),
  },
  reducers: {
    incrementCartCount: (state) => {
      state.count += 1;
    },
    decrementCartCount: (state) => {
      state.count -= 1;
    },
    changeCartCount: (state, action) => {
      state.count = action.payload;
    },
  },
});

// Export slice actions
export const { incrementCartCount, decrementCartCount, changeCartCount } = cartSlice.actions;

// Configure the Redux store
export const store = configureStore({
  reducer: {
    cart: cartSlice.reducer,
  },
});

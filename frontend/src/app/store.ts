import { configureStore } from '@reduxjs/toolkit';
import postsReducer from "../components/posts/postsSlice";

const store = configureStore ({
    reducer: postsReducer
});

export type AppDispatch = typeof store.dispatch;
export type RootState = ReturnType<typeof store.getState>;

export default store;

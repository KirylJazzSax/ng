import {createAsyncThunk, createSlice, PayloadAction} from "@reduxjs/toolkit";

export interface PostsState {
    value: any[];
}

const initialState: PostsState = {
    value: [],
}

export const fetchPosts = createAsyncThunk(
    'posts/fetchPosts',
    async () => {
        await setTimeout(() => console.log('await'), 2000);
        return [
            {
                id: 1,
                title: 'title'
            },
            {
                id: 2,
                title: 'title2'
            }
        ];
    }
);

export const postsSlice = createSlice({
    name: 'posts',
    initialState,
    reducers: {
        add: (state, action: PayloadAction<any>) => {
            state.value.push(action.payload);
        },
        setPosts: (state, action: PayloadAction<any[]>) => {
            state.value = action.payload;
        },
    },
    extraReducers: (builder) => {
        builder.addCase(fetchPosts.fulfilled, (state, action) => {
            state.value = action.payload;
            console.log(state.value);
        });
    }
});

export const {add, setPosts} = postsSlice.actions;

export const selectPosts = (state: PostsState) => state.value;

export const selectPost = (state: PostsState) => (id: number) => {
    return state.value.find((p: any) => p.id === id);
};

export default postsSlice.reducer;

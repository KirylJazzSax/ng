import React, {useEffect} from 'react';
import {Box} from "@material-ui/core";
import Post from "./Post";
import {useAppDispatch, useAppSelector} from "../../app/hooks";
import {fetchPosts} from "./postsSlice";

function Posts() {
    const dispatch = useAppDispatch();
    const posts = useAppSelector((state) => state.value);
    useEffect(() => {
        dispatch(fetchPosts());
    }, [dispatch]);
    const postsMapped = posts.map((p: any) => (<Post post={p} />));

    return (
        <Box>
            {postsMapped}
        </Box>
    );
}

export default Posts;

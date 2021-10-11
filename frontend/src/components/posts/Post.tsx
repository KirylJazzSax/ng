import React from 'react';
import {Box, Typography} from "@material-ui/core";

type PostProps = {
    post: any,
}

function Post({ post }: PostProps) {
    return (
        <Box>
           <Typography component="div" variant="h6">{post.title}</Typography>
        </Box>
    );
}

export default Post;

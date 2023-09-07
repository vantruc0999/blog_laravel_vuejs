// AUTHENTICATION
export const API_SIGNIN = "/login"
export const API_SIGNUP = "/register"
export const API_LOGOUT = "/logout"
// POST
export const API_POSTBLOG = "/posts/create-post"
export const API_GETALLPOST = "/posts"
export const API_UPDATEPOST = "/posts/update-post"
export const API_DELETEPOST = "/posts/delete-post"
// BLOGGER
export const API_GETALLBLOGGER = '/bloggers'
export const API_GETAUTHOR = '/blogger'
export const API_GETMYPROFILE = '/blogger/me/profile'
export const API_UPDATEPROFILE = '/blogger/me/update-profile'
export const API_GETFOLLOWAUTHOR = "/blogger/follow"
export const API_GETAUTHORFOLLOWED = "/blogger/check-follow"
export const API_GETFOLLOWER = "/blogger/me/view-follower"
export const API_GETFOLLOWING = "/blogger/me/view-following"
// COMMENT
export const API_POSTCOMMENT = '/comment'
export const API_EDITCOMMENT = 'comment/edit-comment'
export const API_DELETECOMMENT = '/comment/delete-comment'
// GET TAGS
export const API_GETALLTAGS = '/categories-tags'
// LIKE POST
export const API_LIKEPOST = '/like'
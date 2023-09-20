// AUTHENTICATION
export const API_SIGNIN = "/login"
export const API_SIGNUP = "/register"
export const API_LOGOUT = "/logout"
export const API_CHANGEPASSWORD = '/blogger/me/change-password'
export const API_CHANGEEMAIL = '/blogger/me/change-email'
// POST
export const API_POSTBLOG = "/posts/create-post"
export const API_GETALLPOST = "/posts"
export const API_UPDATEPOST = "/posts/update-post"
export const API_DELETEPOST = "/posts/delete-post"
export const API_SAVEPOST = "/save"
export const API_GETALLSAVEPOST = '/save/get-saved-post'
export const API_GETPOSTAUTHORFOLLOWING = '/posts/author/get-post-by-author'
export const API_GETALLPENDINGPOST = 'posts/pending/get-pending-post'
export const API_GETPOSTDRAFTBYID = '/posts/draft'
export const API_DRAFTPOST  = '/posts/create-post-draft'
export const API_GETALLDRAFTPOST = 'posts/draft/get-my-draft'
export const API_GETPENDINGPOSTBYID = 'posts/pending'
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
export const API_REPLYCOMMENT = "/comment/reply-comment"
// GET TAGS
export const API_GETALLTAGS = '/categories-tags'
// LIKE POST
export const API_LIKEPOST = '/like'
export const API_CHECKLIKEDPOST = '/like/check-like'
export const API_LIKECOMMENT = '/like/like-comment'

// Search
export const API_SEARCHPOST = '/posts/filter/filter-post?search'
export const API_FILTERBYCATEGORI = '/posts/category'
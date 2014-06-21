package forum;
public class UserPost {
   private String username;
   private String date;
   private String postData;
   
   UserPost(String username, String date, String postData) {
      this.username = username;
      this.date = date;
      this.postData = postData;
   }
   
   public String getUsername() {
      return username;
   }
   
   public String getDate() {
      return date;
   }
   
   public String getPostData() {
      return postData;
   }
}
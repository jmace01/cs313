package forum;

import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.List;
import java.util.ArrayList;

public class DataHandler {

   private List<UserPost> posts = new ArrayList<UserPost>();
   private String file;
   
   DataHandler (String f) {
      this.file = f;
      getPostsFromFile(f);
   }
   
   private void getPostsFromFile(String f) {
      try {
         FileInputStream fin = new FileInputStream(f);
         char c;
         String line = "";
         while (fin.available() > 0) {
           c = (char) fin.read();
           if (c == '<') {
              String l[] = line.split(">");
              if (l.length > 2) {
                 posts.add(new UserPost(l[0], l[1], l[2]));
              }
              line = "";
           } else {
              line += c;
           }
         }
         fin.close();
       } catch (IOException e) {
         e.printStackTrace();
       }
   }
   
   public List<UserPost> getPosts() {
      return posts;
   }
   
   public void addPost(String username, String date, String postData) {
      UserPost up = new UserPost(username, date, postData.replaceAll("<", "&lt;").replaceAll(">", "&gt;"));
      posts.add(0,up);
      writeToFile();
   }
   
   public void writeToFile() {
      try {
         PrintWriter pw = new PrintWriter(file, "UTF-8");
         for (UserPost p : posts) {
            pw.print(p.getUsername() + ">");
            pw.print(p.getDate()     + ">");
            pw.print(p.getPostData() + "<");
         }
         pw.close();
      } catch (Exception e) {
         e.printStackTrace();
      }
   }
   
}
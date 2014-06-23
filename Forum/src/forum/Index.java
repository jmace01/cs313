package forum;

import java.io.IOException;
import java.util.List;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

/**
 * Servlet implementation class Index
 */
@WebServlet("/Index")
public class Index extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public Index() {
        super();
        // TODO Auto-generated constructor stub
    }

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
	   HttpSession session = request.getSession();
	   if (session.getAttribute("username") == null) {
	      response.sendRedirect("./login.jsp");
	      return;
	   }
	   
	   String f;
	   String path = System.getenv("OPENSHIFT_DATA_DIR");
	   if (path == null) {
	      f = getServletContext().getRealPath("./posts.txt");
	   } else {
	      f = path + "./posts.txt";
	   }
	   
	   DataHandler dh = new DataHandler(f);
	   List<UserPost> list = dh.getPosts();

	   request.setAttribute("posts", list);
	   request.setAttribute("name", session.getAttribute("username"));
	   
	   request.getRequestDispatcher("posts.jsp").forward(request, response);
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
	}

}

import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@WebServlet("/RegistrationServlet")
public class RegistrationServlet extends HttpServlet {
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        response.setContentType("text/html");
        PrintWriter out = response.getWriter();

        String studentName = request.getParameter("studentName");
        String rollNo = request.getParameter("rollNo");
        String gender = request.getParameter("gender");
        String year = request.getParameter("year");
        String department = request.getParameter("department");
        String section = request.getParameter("section");
        String mobileNo = request.getParameter("mobileNo");
        String email = request.getParameter("email");
        String address = request.getParameter("address");
        String city = request.getParameter("city");
        String country = request.getParameter("country");
        String pincode = request.getParameter("pincode");

        out.println("<html><body>");
        out.println("<h2>Registration Details</h2>");
        out.println("<p><strong>Student Name:</strong> " + studentName + "</p>");
        out.println("<p><strong>Roll No:</strong> " + rollNo + "</p>");
        out.println("<p><strong>Gender:</strong> " + gender + "</p>");
        out.println("<p><strong>Year:</strong> " + year + "</p>");
        out.println("<p><strong>Department:</strong> " + department + "</p>");
        out.println("<p><strong>Section:</strong> " + section + "</p>");
        out.println("<p><strong>Mobile No:</strong> " + mobileNo + "</p>");
        out.println("<p><strong>Email:</strong> " + email + "</p>");
        out.println("<p><strong>Address:</strong> " + address + "</p>");
        out.println("<p><strong>City:</strong> " + city + "</p>");
        out.println("<p><strong>Country:</strong> " + country + "</p>");
        out.println("<p><strong>Pincode:</strong> " + pincode + "</p>");
        out.println("</body></html>");
    }
}

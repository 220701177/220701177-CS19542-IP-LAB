import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import org.json.JSONObject;

@WebServlet("/StudentServlet")
public class StudentServlet extends HttpServlet {
    private Connection connect() throws Exception {
        String url = "jdbc:mysql://localhost:3306/SchoolDB";
        String user = "root"; // replace with your MySQL username
        String password = ""; // replace with your MySQL password
        Class.forName("com.mysql.cj.jdbc.Driver");
        return DriverManager.getConnection(url, user, password);
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        response.setContentType("application/json");
        PrintWriter out = response.getWriter();

        String regNo = request.getParameter("reg_no");
        if (regNo != null) {
            try (Connection conn = connect()) {
                String sql = "SELECT name, department, year, email FROM Students WHERE reg_no = ?";
                PreparedStatement stmt = conn.prepareStatement(sql);
                stmt.setInt(1, Integer.parseInt(regNo));
                ResultSet rs = stmt.executeQuery();

                if (rs.next()) {
                    JSONObject studentData = new JSONObject();
                    studentData.put("name", rs.getString("name"));
                    studentData.put("department", rs.getString("department"));
                    studentData.put("year", rs.getInt("year"));
                    studentData.put("email", rs.getString("email"));
                    out.print(studentData);
                } else {
                    out.print("{}"); // Empty JSON if student not found
                }
            } catch (Exception e) {
                e.printStackTrace();
            }
        }
    }
}

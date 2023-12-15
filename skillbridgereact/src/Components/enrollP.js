import React, { useState, useEffect } from "react";
import "../css/signup.css";
import avatar from "../assets/logo.png";
import { Link } from "react-router-dom";
import { useLocation } from "react-router-dom";
import Swal from "sweetalert2";
function EnrollPrograms() {
  const { search } = useLocation();
  const searchParams = new URLSearchParams(search);
  const email = searchParams.get("email");
  const [course, setCourse] = useState([]);
  const [selectedCourse, setSelectedCourse] = useState(""); // Added state for selected course
  const [courseName, setCourseName] = useState("");
  const [instructorName, setInstructorName] = useState("");
  const [coursePeriod, setPeriod] = useState("");
  const [name, setName] = useState("");
  const [s, setS] = useState("");
  const [ss, setSS] = useState("");
  const handleFormSubmit = (e) => {
    e.preventDefault();
    const formData = new FormData();
    formData.append("course_id", selectedCourse);
    formData.append("name", name);
    formData.append("email", email);
    formData.append("courseName", courseName);
    formData.append("instructorName", instructorName);
    formData.append("coursePeriod", coursePeriod);
    formData.append("s", s);
    formData.append("ss", ss);

    fetch("http://127.0.0.1:8000/api/enrollProgram", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        if (data === "Course enrolled successfully") {
          Swal.fire(
            "Success!",
            "Course enrolled successfully!",
            "success"
          ).then((result) => {
            if (result.isConfirmed) {
              window.location.href = `/student?email=${email}`;
            }
          });
        } else {
          Swal.fire("Oops!", "You have already enrolled", "error").then(
            (result) => {
              if (result.isConfirmed) {
                window.location.href = `/student?email=${email}`;
              }
            }
          );
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        Swal.fire(
          "Oops!",
          "An error occurred while updating the course.",
          "error"
        ).then((result) => {
          if (result.isConfirmed) {
            window.location.href = `/student?email=${email}`;
          }
        });
      });
  };
  useEffect(() => {
    fetch("http://127.0.0.1:8000/api/fetchPrograms")
      .then((response) => response.json())
      .then((data) => {
        setCourse(data);
      })
      .catch((error) => {
        console.error("Error fetching data:", error);
      });
    fetch("http://127.0.0.1:8000/api/getName", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `email=${email}`,
    })
      .then((response) => response.text())
      .then((data) => {
        setName(data);
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }, []);

  const fetchCourseInfo = (courseId) => {
    fetch("http://127.0.0.1:8000/api/fetchPrograms2", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `courseId=${courseId}`,
    })
      .then((response) => response.text())
      .then((data) => {
        const [courseName, instructorName, period, s, ss] = data.split(","); // Split data into an array
        setCourseName(courseName);
        setInstructorName(instructorName);
        setPeriod(period);
        setS(s);
        setSS(ss);
      })
      .catch((error) => {
        console.error("Error:", error);
        Swal.fire(
          "Oops!",
          "An error occurred while fetching the user.",
          "error"
        ).then((result) => {
          if (result.isConfirmed) {
            window.location.href = `/student?email=${email}`;
          }
        });
      });
  };

  const handleCourseSelect = (e) => {
    const selectedCourseId = e.target.value;
    setSelectedCourse(selectedCourseId);
    fetchCourseInfo(selectedCourseId);
  };
  return (
    <div className="signbody">
      <header>
        <img className="signuplogo" src={avatar} alt="skillbridge" />
      </header>
      <div className="signlogin-wrapper">
        <form onSubmit={handleFormSubmit} method="POST" className="signform">
          <h3>Enroll Courses</h3>
          <div className="signinput-group">
            <div className="signselect-container">
              <select
                name="course_id"
                id="courseSelect"
                onChange={handleCourseSelect}
              >
                <option value="">Select a program</option>
                {course.map((courses, index) => (
                  <option key={index} value={courses}>
                    {courses}
                  </option>
                ))}
              </select>

              <div className="signselect-arrow"></div>
            </div>
            <div className="signinput-group">
              <input
                type="text"
                name="course_id" // Set the name attribute to "lastname"
                id="loginUser"
                placeholder="Program Organizer"
                value={courseName}
                readOnly
                required
              />
            </div>
            <div className="signinput-group">
              <input
                type="text"
                name="course_id" // Set the name attribute to "lastname"
                id="loginUser"
                placeholder="Program Description"
                value={instructorName}
                readOnly
                required
              />
            </div>
            <div className="signinput-group">
              <input
                type="text"
                name="course_id" // Set the name attribute to "lastname"
                id="loginUser"
                placeholder="Start Date"
                value={coursePeriod}
                readOnly
                required
              />
            </div>
            <div className="signinput-group">
              <input
                type="text"
                name="course_id" // Set the name attribute to "lastname"
                id="loginUser"
                placeholder="End Date"
                value={s}
                readOnly
                required
              />
            </div>
            <div className="signinput-group">
              <input
                type="text"
                name="course_id" // Set the name attribute to "lastname"
                id="loginUser"
                placeholder="Venue"
                value={ss}
                readOnly
                required
              />
            </div>
          </div>

          <input type="submit" value="Enroll" className="signsubmit-btn" />
          <Link to={`/student?email=${email}`} className="signforgot-pw">
            Go Back
          </Link>
        </form>
      </div>
    </div>
  );
}

export default EnrollPrograms;

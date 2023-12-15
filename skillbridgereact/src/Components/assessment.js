import React, { useState, useEffect } from "react";
import "../css/signup.css";

import avatar from "../assets/logo.png";
import { Link } from "react-router-dom";
import { useLocation } from "react-router-dom";
import Swal from "sweetalert2";

function Assessment() {
  const { search } = useLocation();
  const searchParams = new URLSearchParams(search);
  const email = searchParams.get("email");
  const [exam, setExam] = useState("");
  const [startTime, setStartTime] = useState("");
  const [endTime, setEndTime] = useState("");
  const [quizlink, setQuizLink] = useState("");
  const [resources, setResources] = useState("");
  const [courseData, setCourseData] = useState([]);
  const [uniqueCourseIds, setUniqueCourseIds] = useState(new Set());
  const [selectedCourse, setSelectedCourse] = useState(""); // Added state for selected course
  const [courseName, setCourseName] = useState("");
  const [instructorName, setInstructorName] = useState("");
  const [coursePeriod, setPeriod] = useState("");
  const [name, setName] = useState("");

  const handleFormSubmit = (e) => {
    e.preventDefault();
    fetch("http://127.0.0.1:8000/api/addExam", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `courseId=${selectedCourse}&exam=${exam}&startTime=${startTime}&endTime=${endTime}&quizlink=${quizlink}&resources=${resources}`,
    })
      .then((response) => response.text())
      .then((data) => {
        if (data === "Exam added successfully") {
          Swal.fire("Success!", "Exam added successfully!", "success").then(
            (result) => {
              if (result.isConfirmed) {
                window.location.href = `/instructor?email=${email}`;
              }
            }
          );
        } else {
          Swal.fire("Oops!", "Failed to add exam", "error").then((result) => {
            if (result.isConfirmed) {
              window.location.href = `/instructor?email=${email}`;
            }
          });
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        Swal.fire(
          "Oops!",
          "An error occurred while registering the user.",
          "error"
        ).then((result) => {
          if (result.isConfirmed) {
            window.location.href = `/instructor?email=${email}`;
          }
        });
      });
  };

  useEffect(() => {
    fetch("http://127.0.0.1:8000/api/fetchCourseIdEmail")
      .then((response) => response.json())
      .then((data) => {
        setCourseData(data);
        const uniqueIds = new Set(data.map((course) => course.courseId));
        setUniqueCourseIds(uniqueIds);
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

  const handleCourseSelect = (e) => {
    const selectedCourseId = e.target.value;
    setSelectedCourse(selectedCourseId);
  };

  return (
    <div>
      <html lang="en">
        <head>
          <meta charset="UTF-8" />
          <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
          />
          <meta http-equiv="X-UA-Compatible" content="ie=edge" />
          <link rel="stylesheet" href="../css/signup.css" />
          <title>Add Assessment</title>
        </head>
        <body className="signbody">
          <header>
            <img className="signuplogo" src={avatar} alt="skillbridge" />
          </header>
          <div className="signlogin-wrapper">
            <form
              onSubmit={handleFormSubmit}
              method="POST"
              className="signform"
            >
              <h3>Add Courses</h3>
              <div className="signselect-container">
                <select
                  name="course_id"
                  id="courseSelect"
                  onChange={handleCourseSelect}
                >
                  <option value="">Select a course</option>
                  {[...uniqueCourseIds].map((courseId, index) => {
                    const course = courseData.find(
                      (course) => course.courseId === courseId
                    );
                    if (course && course.professorName === name) {
                      return (
                        <option key={index} value={course.courseId}>
                          {course.courseId}
                        </option>
                      );
                    }
                    return null;
                  })}
                </select>
                <div className="signselect-arrow"></div>
              </div>

              <div className="signinput-group">
                <input
                  type="text"
                  name="exam" // Set the name attribute to "firstname"
                  id="loginUser"
                  onChange={(e) => setExam(e.target.value)} // Extract and set the value
                  required
                />
                <label for="loginUser">Assessment Name</label>
              </div>
              <div className="signinput-group">
                <input
                  type="text"
                  name="startTime" // Set the name attribute to "lastname"
                  id="loginUser"
                  onChange={(e) => setStartTime(e.target.value)} // Extract and set the value
                  required
                />
                <label for="loginUser">Exam Start Time</label>
              </div>
              <div className="signinput-group">
                <input
                  type="text"
                  name="endTime" // Set the name attribute to "lastname"
                  id="loginUser"
                  onChange={(e) => setEndTime(e.target.value)} // Extract and set the value
                  required
                />
                <label for="loginUser">Exam End Time</label>
              </div>
              <div className="signinput-group">
                <input
                  type="text"
                  name="quizlink" // Set the name attribute to "lastname"
                  id="loginUser"
                  onChange={(e) => setQuizLink(e.target.value)} // Extract and set the value
                  required
                />
                <label for="loginUser">Quiz Link</label>
              </div>
              <div className="signinput-group">
                <input
                  type="text"
                  name="resources" // Set the name attribute to "lastname"
                  id="loginUser"
                  onChange={(e) => setResources(e.target.value)} // Extract and set the value
                  required
                />
                <label for="loginUser">Resources</label>
              </div>
              <input
                type="submit"
                value="Continue"
                className="signsubmit-btn"
              />
              {/* <a href="login.html" className="signforgot-pw">Sign in instead</a> */}
              <Link to={`/instructor?email=${email}`} className="signforgot-pw">
                Go Back
              </Link>
            </form>
          </div>
        </body>
      </html>
    </div>
  );
}

export default Assessment;

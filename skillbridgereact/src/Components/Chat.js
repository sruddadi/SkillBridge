import React, { useEffect, useState } from "react";
import ScrollToBottom from "react-scroll-to-bottom";
import "../css/style.css"; // Import your CSS file
import DropDownProfile from "./dropdown";
import { useLocation } from "react-router-dom";
import avatar1 from "../assets/avatar4.jpeg";
import { Link } from "react-router-dom";

function Chat({ socket, username, room, passemail }) {
  const [currentMessage, setCurrentMessage] = useState("");
  const [messageList, setMessageList] = useState([]);
  const { search } = useLocation();
  const searchParams = new URLSearchParams(search);
  const email = passemail;
  const name = searchParams.get("name");
  const [openProfile, setOpenProfile] = useState(false);
  const [role, setRole] = useState("");
  const handleCloseModal = () => {
    setOpenProfile(false);
  };
  const sendMessage = async () => {
    if (currentMessage !== "") {
      const messageData = {
        room: room,
        author: username,
        message: currentMessage,
        time:
          new Date(Date.now()).getHours() +
          ":" +
          new Date(Date.now()).getMinutes(),
      };

      await socket.emit("send_message", messageData);
      setMessageList((list) => [...list, messageData]);
      setCurrentMessage("");
    }
  };

  useEffect(() => {
    const handleReceivedMessage = (data) => {
      setMessageList((list) => [...list, data]);
      console.log(data);
    };

    socket.on("recieve_message", handleReceivedMessage);

    return () => {
      // Clean up the event listener when the component unmounts
      socket.off("recieve_message", handleReceivedMessage);
    };
  }, [socket]);

  const [admin, setAdmin] = useState("");
  const [students, setStudents] = useState("");
  const [instructors, setInstructors] = useState("");
  const [pc, setPC] = useState("");
  const [qa, setQA] = useState("");

  useEffect(() => {
    fetch("http://127.0.0.1:8000/api/fetchbar")
      .then((response) => response.text())
      .then((data) => {
        const [admin, students, instructors, pc, qa] = data.split(",");
        setAdmin(admin);
        setStudents(students);
        setInstructors(instructors);
        setPC(pc);
        setQA(qa);
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }, []);

  const loadPrograms = async () => {
    fetch("http://127.0.0.1:8000/api/fetchRole", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `email=${email}`,
    })
      .then((response) => response.text())
      .then((data) => {
        setRole(data);
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  };

  useEffect(() => {
    loadPrograms();
  }, []);

  return (
    <div className="stylecontainer" style={{ marginTop: "-783px" }}>
      <div className="stylesidebar">
        <link
          rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
          integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm"
          crossOrigin="anonymous"
        />
        <ul>
          {role === "Admin" && (
            <>
              <li>
                <Link to={`/admin?email=${email}`}>
                  <i class="fa fa-bars" aria-hidden="true"></i>
                  <div className="styletitle">SkillBridge</div>
                </Link>
              </li>
              <li>
                {/* <a href="#">
              <i className="fas fa-th-large"></i>
              <div className="styletitle">Admin Dashboard</div>
            </a> */}
                <Link to={`/admin?email=${email}`}>
                  <i className="fas fa-th-large"></i>
                  <div className="styletitle">Admin Dashboard</div>
                </Link>
              </li>
              <li>
                <Link to={`/addCourses?email=${email}`}>
                  <i class="fa fa-sticky-note" aria-hidden="true"></i>
                  <div className="styletitle">Add Course</div>
                </Link>
              </li>
              <li>
                <Link to={`/addProgram?email=${email}`}>
                  <i class="fa fa-tasks" aria-hidden="true"></i>
                  <div className="styletitle">Add Programs</div>
                </Link>
              </li>
              <li>
                <Link to={`/addUser?email=${email}`}>
                  <i class="fa fa-users" aria-hidden="true"></i>
                  <div className="styletitle">Add Users</div>
                </Link>
              </li>
              <li>
                {/* <a href="#">
              <i className="fas fa-tag"></i>
              <div className="styletitle">Repots</div>
            </a> */}
                <Link
                  to={`/reports?email=${email}&admin=${admin}&students=${students}&instructors=${instructors}&pc=${pc}&qa=${qa}&name=${name}`}
                >
                  <i class="fa fa-line-chart" aria-hidden="true"></i>
                  <div className="styletitle">Reports</div>
                </Link>
              </li>
              <li>
                <Link to={`/edit?email=${email}`}>
                  <i class="fa fa-user-md" aria-hidden="true"></i>
                  <div className="styletitle">Edit Profile</div>
                </Link>
              </li>
              <li>
                <Link to={`/messagechat?name=${name}`}>
                  <i class="fa fa-comment" aria-hidden="true"></i>
                  <div className="styletitle">WebChat</div>
                </Link>
              </li>
            </>
          )}
          {role === "Instructor" && (
            <>
              <li>
                <Link to={`/instructor?email=${email}`}>
                  <i className="fas fa-book"></i>
                  <div className="styletitle">SkillBridge</div>
                </Link>
              </li>
              <li>
                <Link to={`/instructor?email=${email}`}>
                  <i className="fas fa-th-large"></i>
                  <div className="styletitle">Instructor Dashboard</div>
                </Link>
              </li>
              <li>
                <Link to={`/addCourses?email=${email}&name=${name}`}>
                  <i className="fa fa-sticky-note"></i>
                  <div className="styletitle">Add Course</div>
                </Link>
              </li>
              <li>
                {/* <a href="#">
              <i className="fas fa-tag"></i>
              <div className="styletitle">Assessment Creation</div>
            </a> */}
                <Link to={`/assessment?email=${email}`}>
                  <i class="fa fa-file" aria-hidden="true"></i>
                  <div className="styletitle">Assessment Creation</div>
                </Link>
              </li>
              <li>
                <Link to={`/edit?email=${email}`}>
                  <i class="fa fa-user-md" aria-hidden="true"></i>
                  <div className="styletitle">Edit Profile</div>
                </Link>
              </li>
              <li>
                <Link to={`/messagechat?name=${name}`}>
                  <i class="fa fa-comment" aria-hidden="true"></i>
                  <div className="styletitle">WebChat</div>
                </Link>
              </li>
            </>
          )}
          {role === "Program Coordinator" && (
            <>
              <li>
                <Link to={`/pc?email=${email}`}>
                  <i className="fas fa-book"></i>
                  <div className="pctitle">SkillBridge</div>
                </Link>
              </li>
              <li>
                <Link to={`/pc?email=${email}`}>
                  <i className="fas fa-th-large"></i>
                  <div className="pctitle">PC Dashboard</div>
                </Link>
              </li>
              <li>
                <Link to={`/addProgram?email=${email}`}>
                  <i class="fa fa-tasks" aria-hidden="true"></i>
                  <div className="pctitle">Add Programs</div>
                </Link>
              </li>
              <li>
                <Link to={`/pcreports?email=${email}&name=${name}`}>
                  <i class="fa fa-line-chart" aria-hidden="true"></i>
                  <div className="pctitle">Reports</div>
                </Link>
              </li>
              <li>
                <Link to={`/edit?email=${email}`}>
                  <i class="fa fa-user-md" aria-hidden="true"></i>
                  <div className="pctitle">Edit Profile</div>
                </Link>
              </li>
              <li>
                <Link to={`/messagechat?name=${name}&email=${email}`}>
                  <i class="fa fa-comment" aria-hidden="true"></i>
                  <div className="pctitle">WebChat</div>
                </Link>
              </li>
            </>
          )}
          {role === "QA Officer" && (
            <>
              <li>
                <Link to={`/QAOrganizer?email=${email}`}>
                  <i class="fa fa-bars" aria-hidden="true"></i>
                  <div className="styletitle">SkillBridge</div>
                </Link>
              </li>
              <li>
                <Link to={`/QAOrganizer?email=${email}`}>
                  <i className="fas fa-th-large"></i>
                  <div className="styletitle">QA Dashboard</div>
                </Link>
              </li>
              <li>
                <Link to={`/addQA?email=${email}`}>
                  <i class="fa fa-file-archive-o" aria-hidden="true"></i>
                  <div className="styletitle">Add Policies</div>
                </Link>
              </li>
              <li>
                <Link to={`/edit?email=${email}`}>
                  <i className="fas fa-user"></i>
                  <div className="styletitle">Edit Profile</div>
                </Link>
              </li>
              <li>
                <Link to={`/messagechat?name=${name}&email=${email}`}>
                  <i class="fa fa-comment" aria-hidden="true"></i>
                  <div className="styletitle">WebChat</div>
                </Link>
              </li>
            </>
          )}
          {role === "Student" && (
            <>
              <li>
                <Link to={`/student?email=${email}`}>
                  <i className="fas fa-book"></i>
                  <div className="styletitle">SkillBridge</div>
                </Link>
              </li>
              <li>
                <Link to={`/student?email=${email}`}>
                  <i className="fas fa-th-large"></i>
                  <div className="styletitle">Student Dashboard</div>
                </Link>
              </li>
              <li>
                <Link to={`/enrollC?email=${email}`}>
                  <i class="fa fa-sticky-note" aria-hidden="true"></i>
                  <div className="styletitle">Enroll Courses</div>
                </Link>
              </li>
              <li>
                <Link to={`/enrollPrograms?email=${email}`}>
                  <i class="fa fa-tasks" aria-hidden="true"></i>
                  <div className="styletitle">Enroll Programs</div>
                </Link>
              </li>
              <li>
                <Link to={`/edit?email=${email}`}>
                  <i class="fa fa-user-md" aria-hidden="true"></i>
                  <div className="styletitle">Edit Profile</div>
                </Link>
              </li>
              <li>
                <Link to={`/messagechat?name=${name}&email=${email}`}>
                  <i class="fa fa-comment" aria-hidden="true"></i>
                  <div className="styletitle">WebChat</div>
                </Link>
              </li>
            </>
          )}
        </ul>
      </div>
      <div className="stylemain">
        <div className="styletop-bar">
          <div className="stylesearch">
            <input type="text" name="search" placeholder="Search here.." />
            <label htmlFor="search">
              <i className="fas fa-search"></i>
            </label>
          </div>
          <i>{name}</i>
          <div
            className="styleuser"
            onClick={() => setOpenProfile((prev) => !prev)}
          >
            {/* <img src="images/avatar.png" alt="User Avatar" /> */}
            <img src={avatar1} alt="skillbridge" />
          </div>
          {openProfile && (
            <DropDownProfile email={email} closeModal={handleCloseModal} />
          )}
        </div>
        <div className="stylecards">
          <div></div>
        </div>
        <div className="chat-window">
          <div className="chat-header">
            <p>Live Chat</p>
          </div>
          <div className="chat-body">
            <ScrollToBottom className="message-container">
              {messageList.map((messageContent) => {
                return (
                  <div
                    className="message"
                    id={username === messageContent.author ? "you" : "other"}
                  >
                    <div>
                      <div className="message-content">
                        <p>{messageContent.message}</p>
                      </div>
                      <div className="message-meta">
                        <p id="time">{messageContent.time}</p>
                        <p id="author">{messageContent.author}</p>
                      </div>
                    </div>
                  </div>
                );
              })}
            </ScrollToBottom>
          </div>
          <div className="chat-footer">
            <input
              type="text"
              value={currentMessage}
              placeholder="Type a message...."
              onChange={(e) => {
                setCurrentMessage(e.target.value);
              }}
              onKeyPress={(e) => {
                e.key === "Enter" && sendMessage();
              }}
            />
            <button onClick={sendMessage}>&#9658;</button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Chat;

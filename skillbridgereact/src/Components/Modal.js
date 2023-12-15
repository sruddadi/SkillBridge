import React, { useState, useEffect } from "react";
import "../css/modal.css"; // Import your CSS file

const Modal = ({ email, closeModal }) => {
  const [modal, setModal] = useState(false);
  const [fname, setFname] = useState("");
  const [lname, setLname] = useState("");
  const [role, setRole] = useState("");
  const loadPrograms = async () => {
    fetch("http://127.0.0.1:8000/api/fetchModal", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `email=${email}`,
    })
      .then((response) => response.text())
      .then((data) => {
        const [fname, lname, role] = data.split(",");
        setFname(fname);
        setLname(lname);
        setRole(role);
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  };

  const toggleModal = () => {
    setModal(!modal);
    closeModal();
  };

  if (modal) {
    document.body.classList.add("active-modal");
  } else {
    document.body.classList.remove("active-modal");
  }

  useEffect(() => {
    loadPrograms();
    setModal(!modal);
  }, []);

  return (
    <>
      {modal && (
        <div className="modal">
          <div onClick={toggleModal} className="overlay"></div>
          <div className="modal-content">
            <h3>Profile Details</h3>
            <p>
              Name: {fname} {lname} <br></br>
              Email: {email} <br></br>
              Role: {role}
            </p>
            <button className="close-modal" onClick={toggleModal}>
              CLOSE
            </button>
          </div>
        </div>
      )}
    </>
  );
};
export default Modal;

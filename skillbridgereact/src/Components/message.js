import "../css/App.css";
import io from "socket.io-client";
import React, { useState } from "react";
import Chat from "./Chat";
import { useLocation } from "react-router-dom";

const socket = io.connect("http://localhost:3001");

function Message() {
  const { search } = useLocation();
  const searchParams = new URLSearchParams(search);
  const name = searchParams.get("name");
  const email = searchParams.get("email");
  const [username, setUsername] = useState(name);
  const [room, setRoom] = useState("1234");
  socket.emit("join_room", room);

  return (
    <div className="Message">
      <Chat socket={socket} username={username} room={room} passemail={email} />
    </div>
  );
}

export default Message;

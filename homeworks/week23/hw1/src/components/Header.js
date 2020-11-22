import React from 'react';
import { Navbar } from 'react-bootstrap';

const Header = () => {
  return (
    <header>
      <Navbar bg="primary" variant="dark" expand="md">
        <Navbar.Brand href="#">Bucket List</Navbar.Brand>
      </Navbar>
    </header>
  );
}

export default Header;
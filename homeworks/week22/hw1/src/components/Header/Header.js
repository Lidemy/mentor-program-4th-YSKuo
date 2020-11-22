import React, { useContext } from 'react';
import styled from 'styled-components';
import { AuthContext } from '../../contexts';
import { setAuthToken } from '../../utils';

import { Link, useLocation, useHistory } from 'react-router-dom';

const HeaderContainer = styled.div`
  height: 64px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  border: 1px solid rgba(0, 0, 0, 0.2);
  padding: 0 32px;
  box-sizing: border-box;
  background-color: white;
`;

const Brand = styled.div`
  font-size: 32px;
  font-weight: bold;
`;

const NavbarList = styled.div`
  display: flex;
  align-items: center;
  height: 64px;
`;

const Nav = styled(Link)`
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  box-sizing: border-box;
  width: 100px;
  cursor: pointer;
  color: black;
  text-decoration: none;

  ${(props) => 
    props.$active && 
    `
    background: rgba(0, 0, 0, 0.2);
  `}
`;

const LeftContainer = styled.div`
  display: flex;
  align-items: center;

  ${NavbarList} {
    margin-left: 64px;
  }
`;

export default function Header() {
  const location = useLocation();
  const history = useHistory();
  const { user, setUser } = useContext(AuthContext);

  const handleLogout = () => {
    setAuthToken('');
    setUser(null);
    if (location.pathname !== '/') {
      history.push('/');
    }
  };

  return (
    <HeaderContainer>
      <LeftContainer>
        <Brand>我的第一個 Blog</Brand>
        <NavbarList>
          <Nav to='/' $active={location.pathname === '/'}>首頁</Nav>
          <Nav to='/about' $active={location.pathname === '/about'} >關於</Nav>
          {user && 
            <Nav to='/new-post' $active={location.pathname === '/new-post'}>發布</Nav>
          }
        </NavbarList>
      </LeftContainer>
      <NavbarList>
        {!user && (
          <>
            <Nav to='/sign-up' $active={location.pathname === '/sign-up'}>註冊</Nav>
            <Nav to='/login' $active={location.pathname === '/login'}>登入</Nav>
          </>
        )}
        {user && (<Nav onClick={handleLogout}>登出</Nav>)}
      </NavbarList>
    </HeaderContainer>
  );
}

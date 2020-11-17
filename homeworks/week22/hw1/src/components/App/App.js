import React, { useState, useEffect } from 'react';
import styled from 'styled-components';
import SignUpPage from '../../pages/SignUpPage';
import LoginPage from '../../pages/LoginPage';
import HomePage from '../../pages/HomePage';
import AboutPage from '../../pages/AboutPage';
import PostPage from '../../pages/PostPage';
import CreateNewPostPage from '../../pages/CreateNewPostPage';
import Header from '../Header';
import { AuthContext } from '../../contexts';
import { getMe } from '../../WebAPI';
import { getAuthToken } from '../../utils';

import { HashRouter as Router, Switch, Route } from 'react-router-dom';

const Root = styled.div`
  padding-top: 64px;
`;

function App() {
  const [user, setUser] = useState(null);

  useEffect(() => {
    // 登入狀態處理
    if (getAuthToken()) {
      getMe().then((response) => {
        if (response.ok) {
          setUser(response.data);
        }
      })
    }
  }, []);

  return (
    <AuthContext.Provider value={{user, setUser}}>
      <Root>
        <Router>
          <Header>Header</Header>
          <Switch>
            <Route exact path='/'>
              <HomePage />
            </Route>
            <Route path='/about'>
              <AboutPage />
            </Route>
            <Route path='/login'>
              <LoginPage />
            </Route>
            <Route path='/sign-up'>
              <SignUpPage />
            </Route>
            <Route path='/post/:id'>
              <PostPage />
            </Route>
            <Route path='/new-post'>
              <CreateNewPostPage />
            </Route>
          </Switch>
        </Router>
      </Root>
    </AuthContext.Provider>
  );
}

export default App;

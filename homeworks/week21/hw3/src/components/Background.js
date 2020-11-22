import styled from "styled-components";
import Form from './components/Form';

const Background = styled.div`
  background-color: #e4e4e4;
  padding: 120px 0 66px 0;
`;

export default () => (
  <Background>
    <Form />
  </Background>
);

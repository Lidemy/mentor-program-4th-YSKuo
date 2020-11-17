import styled from "styled-components";
import Form from './Form';
import { MEDIA_QUERY_MD } from '../constants/style';

const Main = styled.main`
  background-color: #e4e4e4;
  padding: 120px 0 66px 0;

  ${MEDIA_QUERY_MD} {
    padding: 0;
  }
`;

export default () => {
  return (
    <Main>
      <Form />
    </Main>
  );
};
import styled from "styled-components";
import { MEDIA_QUERY_MD } from '../../constants/style';

export const FormSubtitle = styled.h2`
  margin-top: 50px;
`;

export const RequiredTag = styled.span`
  content: "*";
  color: #e74149;
`;

export const FormInput = styled.div`
  font-size: 16px;

  input {
    width: 50%;
    color: #afafaf;
    border: solid 1px #d0d0d0;
    margin-top: 20px;
    padding: 5px 0 3px 0;
    display: flex;
  }

  ${MEDIA_QUERY_MD} {
    input {
      width: 100%;
    }
  }
`;

export const FormOption = styled.div`
  label {
    display: block;
    font-size: 14px;
    margin-top: 24px;
    display: flex;
  }

  input {
    margin-right: 10px;
  }
`;

export const FormDesc = styled.p`
  margin-top: 12px;
  color: black;
`;

export const FormSubmit = styled.button`
  font-size: 15px;
  background-color: #fad312;
  padding: 13px 31px;
  margin-top: 55px;
  text-align: center;
  border-radius: 3px;
  border: 0px;
  width: 92px;
  box-sizing: border-box;

  p {
    margin-top: 20px;
  }
`;

export const Warning = styled.p`
  ${'' /* content: '此欄為必填'; */}
  font-size: 12px;
  color: red;
  margin-top: 5px;
  position: absolute;
`;

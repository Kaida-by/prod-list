FROM node:18

ENV APP_ROOT /frontend

RUN mkdir ${APP_ROOT}
WORKDIR ${APP_ROOT}
COPY ./frontend ${APP_ROOT}

RUN npm install
RUN npm run build

ENV HOST 0.0.0.0
ENV PORT 8080

EXPOSE 8080

CMD [ "npm", "run", "dev" ]
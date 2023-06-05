FROM node:12.20.1-alpine

ENV APP_ROOT /srv/app

RUN mkdir ${APP_ROOT}
WORKDIR ${APP_ROOT}
ADD ./frontend ${APP_ROOT}

RUN npm install
# RUN npm run build

ENV HOST 0.0.0.0
ENV PORT 8080

# EXPOSE 8080

CMD ['npm', 'run', 'dev']
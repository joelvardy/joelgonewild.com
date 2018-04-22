FROM circleci/node:9-browsers

RUN sudo apt-get -y -qq update && \
    sudo apt-get -y -qq install gcc g++ libvips libvips-dev && \
    sudo apt-get -y -qq install python3.4-dev && \
    sudo curl -O https://bootstrap.pypa.io/get-pip.py && \
    sudo python3.4 get-pip.py && \
    sudo pip install awscli --upgrade

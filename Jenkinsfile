pipeline {
    agent any

    environment {
        AWS_REGION = 'us-east-1' // e.g., us-east-1
        ECR_REPOSITORY = 'ecommerce/backend'
        IMAGE_TAG = "${env.BUILD_ID}" // or use a specific tag
        KUBECONFIG = credentials('kubeconfig-credential-id') // Replace with your Kubernetes credentials ID
        AWS_ACCOUNT_ID = '075884725528'
        NAMESPACE = 'myapp'
    }

    stages {
        stage('Checkout') {
            steps {
                script {
                    // This will use the SCM configuration defined in the pipeline.
                    checkout scm
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    // Build Docker image
                    sh """
                        docker build -t ${ECR_REPOSITORY}:${IMAGE_TAG} .
                    """
                }
            }
        }

        stage('Login to ECR') {
            steps {
                script {
                    // Log in to ECR
                    sh """
                        aws ecr get-login-password --region ${AWS_REGION} | docker login --username AWS --password-stdin ${AWS_ACCOUNT_ID}.dkr.ecr.${AWS_REGION}.amazonaws.com
                    """
                }
            }
        }

        stage('Push Docker Image to ECR') {
            steps {
                script {
                    // Push the Docker image to ECR
                    sh """
                        docker tag ${ECR_REPOSITORY}:${IMAGE_TAG} ${AWS_ACCOUNT_ID}.dkr.ecr.${AWS_REGION}.amazonaws.com/${ECR_REPOSITORY}:${IMAGE_TAG}
                        docker push ${AWS_ACCOUNT_ID}.dkr.ecr.${AWS_REGION}.amazonaws.com/${ECR_REPOSITORY}:${IMAGE_TAG}
                    """
                }
            }
        }

        stage('Deploy to EKS') {
            steps {
                script {
                    // Deploy the Helm chart
                    sh """
                        helm upgrade --install frontend-${BUILD_ID} ./react-app --namespace ${NAMESPACE} --set image.repository=${AWS_ACCOUNT_ID}.dkr.ecr.${AWS_REGION}.amazonaws.com/${ECR_REPOSITORY} --set image.tag=${IMAGE_TAG}
                    """
                }
            }
        }
    }

    post {
        success {
            echo 'Deployment successful!'
        }
        failure {
            echo 'Deployment failed!'
        }
    }
}
